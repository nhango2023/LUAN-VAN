from llm.utils.split_document import SplitDocument

from llm.llm_level.llm import LLM_LEVEL
from llm.llm_level.grade_document_level_template import DocumentGraderLevel

from llm.llm_generate_question.llm import LLM_GENERATE_QUESTION
from llm.llm_generate_question.generate_question_template import GenerateQuestion

from llm.llm_grade_question.llm import LLM_GRADE_QUESTION
from llm.llm_grade_question.grade_question_template import GradeDocument

from llm.utils.calculate_number_question_each_level import CalculateQuestion

import os
from dotenv import load_dotenv

# Load biến môi trường từ file .env ở thư mục gốc
dotenv_path = os.path.join(os.path.dirname(os.path.dirname(__file__)), ".env")
load_dotenv(dotenv_path)


class FilesChatAgent:
    def __init__(self, doc, number_question, model):
        self.doc = doc #tai lieu cua nguoi dung
        self.splitted_docs=""#tai lieu sau khi duoc chia thanh cac doan nho
        self.number_question=number_question #so luong cau hoi do nguoi dung yeu cau
        self.splitter_doc= SplitDocument() #lop chia tai lieu thanh nhung doan nho
        self.llm_grader_level = DocumentGraderLevel(LLM_LEVEL().get_llm()).get_chain() #lop danh gia level theo thang bloom cua tung doan
        self.calculate_question = CalculateQuestion(number_question) #lop tinh toan so luong cau hoi cho tung doan nho theo tung level
        self.llm_generate = GenerateQuestion(LLM_GENERATE_QUESTION().get_llm(model)).get_chain() #lop tao cau hoi
        self.llm_grade = GradeDocument(LLM_GRADE_QUESTION().get_llm()).get_chain() #lop danh gia lien quan giua cau hoi, cau tra loi va doan nho tai lieu
        self.questions=[]
        self.lst_keyword={
            "remember": os.getenv("KEYWORD_REMEMBER"),
            "understand": os.getenv("KEYWORD_UNDERSTAND"),
            "apply": os.getenv("KEYWORD_APPLY"),
            "analyze": os.getenv("KEYWORD_ANALYZE"),
            "evaluate" : os.getenv("KEYWORD_EVALUATE"),
            "create" : os.getenv("KEYWORD_CREATE")
        }

    async def split_document(self):
        self.splitted_docs= await self.splitter_doc.process_file(self.doc)
        print(f"Number of paragraphs: {len(self.splitted_docs)}")
        print("\n")

    def detect_level_and_calculate_question(self):
        for idx, text in enumerate(self.splitted_docs):
            result = self.llm_grader_level.invoke({"document": self.splitted_docs[idx].page_content})     
            print(f'doan van-[{idx}]: {result.level}')
            self.calculate_question.sort_idx_doc_with_its_level(idx, result.level)

        print("Check there are levels not detected in paragraphs")
        self.calculate_question.handle_level_not_detected()

        print("index of splited docs following its level")    
        for level, questions in self.calculate_question.idx_doc_by_level.items():
            print(f"{level}: {questions}")
        
        self.calculate_question.calculate_number_question_for_each_splited_docs()
        print("\nnumber of questions for each paragraph arranged in order of paragraph's index \n")
        for level, questions in self.calculate_question.number_question_for_each_splited_doc.items():
            print(f"level: {level}")
            print(f"idx: {self.calculate_question.idx_doc_by_level[level]}")
            print(f"number questions: {questions}")
        print("\n")



    def generate_question_and_grade_question(self, max_attempts=3):
        #duyet qua tung level va so luong cau hoi tung level
        for level, count in self.number_question.items():
            keyword=self.lst_keyword[level]
            
            #duyet qua index cua paragraph
            for idx, idx_splited_doc in enumerate(self.calculate_question.idx_doc_by_level[level]):
                #tai lieu
                splited_doc = self.splitted_docs[idx_splited_doc].page_content
                #so luong cau hoi cho tai lieu
                number_required_questions = self.calculate_question.number_question_for_each_splited_doc[level][idx]
                #tu khoa cua cap do 
                lst_current_questions = []    
                attempts = 0
                while len(lst_current_questions) < number_required_questions and attempts<max_attempts:                    
                    needed_question = number_required_questions - len(lst_current_questions)                
                    if attempts>0 and needed_question>0:
                        print(f"tao lai cau hoi level:{level}...")
                    else:
                        print(f"\ntao cau hoi level:{level}...\n")
                    
                    result = self.llm_generate.invoke({
                        "document": splited_doc,
                        "keyword": keyword,
                        "n_question": needed_question
                    })
                    if result is None:
                        print("Khong the tao cau hoi!!!")
                    else:                       
                        print("danh gia cau hoi....")
                        for q in result.Question:
                            print(f"Question: {q.question}\nanswer: {q.answer}")                  
                            score = self.llm_grade.invoke({
                                    "document": splited_doc,
                                    "question": q.question,
                                    "suggested_answer": q.answer
                            })
                            print(f"score: {score}")
                            if score.binary_score == "yes":
                                q.level = level
                                # print(f"new question: {q}")
                                lst_current_questions.append(q)
                            if (attempts==max_attempts):
                                print("attempts==max_attempts")
                                q.level = level
                                lst_current_questions.append(q)

                    print(f"attempts: {attempts}")
                    print(f"number required questions: {number_required_questions}")
                    print(f"number current questions: {len(lst_current_questions)}")
                    attempts += 1   
                
                self.questions.extend(lst_current_questions)                         

    async def get_lst_question(self):
        await self.split_document()
        self.detect_level_and_calculate_question()
        self.generate_question_and_grade_question()
        return self.questions

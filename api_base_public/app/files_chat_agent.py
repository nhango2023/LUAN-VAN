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
        self.generate = GenerateQuestion(LLM_GENERATE_QUESTION().get_llm(model))
        self.llm_generate = self.generate.get_chain()
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
                page = self.splitted_docs[idx_splited_doc].metadata["page"]
                #so luong cau hoi cho tai lieu
                number_required_questions = self.calculate_question.number_question_for_each_splited_doc[level][idx]
                #tu khoa cua cap do 
                lst_current_questions = []   
                lst_questions_without_keywords = [] 
                total_invalid_questions = 0
                attempts = 0
                while len(lst_current_questions) < number_required_questions and attempts<max_attempts:                    
                    needed_question = number_required_questions - len(lst_current_questions)                
                    if attempts>0 and needed_question>0:
                        print(f"\ntao lai cau hoi level:{level}...")
                    else:
                        print(f"\ntao cau hoi level:{level}...\n")
                    
                    
                    existing_questions = "\n".join(
                        f"+{item.question}" for item in self.questions if item.page==1 
                    )
                     
                    lst_questions_without_keywords_format_text = "\n".join(
                        f"+{item}" for item in lst_questions_without_keywords
                    )

                    # Create input
                    input_data = {
                        "document": splited_doc,
                        "keyword": keyword,
                        "n_question": needed_question,
                        "existing_questions": existing_questions,
                        "questions_without_keywords": lst_questions_without_keywords_format_text
                    }

                    print(f"full promt:\n=========\n{self.generate.render_prompt(input_data)}\n===============\n")
                    result = self.llm_generate.invoke(input_data)
                    
                    if result is None:
                        print("Khong the tao cau hoi!!!")
                    else:                       
                        print("Danh gia cau hoi....")

                        for q in result.Question:
                            matched_keyword=self.check_keyword_in_question(q.question, level)
                            print(f"Answer: {q.answer}")  
                            print(f"Keyword: {matched_keyword}")
                            if (matched_keyword):                
                                score = self.llm_grade.invoke({
                                        "document": splited_doc,
                                        "question": q.question,
                                        "suggested_answer": q.answer
                                })
                                print(f"Lien quan: {score.binary_score}")
                                if score.binary_score == "yes":
                                    q.level = level
                                    q.page=page
                                    print(f"cau hoi dung: {q}")
                                    lst_current_questions.append(q)
                            else:
                                lst_questions_without_keywords.append(q.question)
                                total_invalid_questions += 1


                    print(f"Tạo đủ {len(lst_current_questions)}/{number_required_questions} câu hỏi")
                    print(f"Số câu không có từ khóa: {total_invalid_questions}")
                    print(f"Số lần tạo lại: {attempts}")

                    attempts += 1
                    if len(lst_current_questions) >= number_required_questions:
                        break   

                self.questions.extend(lst_current_questions)                         

    def check_keyword_in_question(self, question: str, level: str):
        """
        Kiểm tra xem câu hỏi có chứa từ khóa thuộc cấp độ Bloom đã cho hay không.

        Args:
            question (str): Nội dung câu hỏi
            level (str): Tên cấp độ Bloom (remember, understand, ...)

        Returns:
            boolean: true nếu có từ khóa phù hợp, false nếu không
        """
        print(f"Level: {level}")
        print(f"Question: {question}")
        question_lower = question.lower()
        keyword_str = self.lst_keyword.get(level)
        if not keyword_str:
            print("keyword rong !!!")
            return False

        for keyword in keyword_str.split(", "):
            if keyword in question_lower:
                print(f"[{keyword}]")
                return True

        return False


    async def get_lst_question(self):
        await self.split_document()
        self.detect_level_and_calculate_question()
        self.generate_question_and_grade_question()
        return self.questions

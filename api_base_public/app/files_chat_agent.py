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
import string


# Load biến môi trường từ file .env ở thư mục gốc
dotenv_path = os.path.join(os.path.dirname(os.path.dirname(__file__)), ".env")
load_dotenv(dotenv_path)


class FilesChatAgent:
    def __init__(self, doc, number_question, model, log_file_path, user_token, task):
        self.task=task
        self.user_token=user_token
        self.log_file_path=log_file_path
        self.doc = doc #tai lieu cua nguoi dung
        self.splitted_docs=""#tai lieu sau khi duoc chia thanh cac doan nho
        self.number_question=number_question #so luong cau hoi do nguoi dung yeu cau

        self.splitter_doc= SplitDocument() #lop chia tai lieu thanh nhung doan nho

        self.calculate_question = CalculateQuestion(number_question, log_file_path) #lop tinh toan so luong cau hoi cho tung doan nho theo tung level

        self.grader_level = DocumentGraderLevel(LLM_LEVEL(log_file_path=log_file_path).get_llm('gpt')) #lop danh gia level theo thang bloom cua tung doan
        self.llm_grader_level=self.grader_level.get_chain()

        self.generate = GenerateQuestion(LLM_GENERATE_QUESTION(log_file_path=log_file_path).get_llm('gpt'))
        self.llm_generate = self.generate.get_chain()

        self.grade = GradeDocument(LLM_GRADE_QUESTION(log_file_path=log_file_path).get_llm('gpt')) #lop danh gia lien quan giua cau hoi, cau tra loi va doan nho tai lieu
        self.llm_grade = self.grade.get_chain()

        self.questions=[]
        self.total_character_used=0
        self.lst_keyword={
            "remember": os.getenv("KEYWORD_REMEMBER"),
            "understand": os.getenv("KEYWORD_UNDERSTAND"),
            "apply": os.getenv("KEYWORD_APPLY"),
            "analyze": os.getenv("KEYWORD_ANALYZE"),
            "evaluate" : os.getenv("KEYWORD_EVALUATE"),
            "create" : os.getenv("KEYWORD_CREATE")
        }

    def split_document(self):
        self.splitted_docs= self.splitter_doc.process_file(self.doc)
        self.write_log(f"Number of paragraphs: {len(self.splitted_docs)}")
        self.write_log("\n")

    def detect_level_and_calculate_question(self):
        for idx, text in enumerate(self.splitted_docs):
            input_data={"document": self.splitted_docs[idx].page_content}
            prompt=self.grader_level.render_prompt(input_data)
            # Calculate the number of characters in the generated prompt
            num_characters_input = len(prompt)
            self.total_character_used+=num_characters_input
            # Print the result
            #print(f"Grader level prompt input contains {num_characters_input} characters.")
            result = self.llm_grader_level.invoke(input_data)
            num_characters_output=len(str(result))
            self.total_character_used+=num_characters_output
            #print(f"Grader level prompt output contains {num_characters_output} characters.") 
            
            self.write_log(f'doan van-[{idx}]: {result.level}')
            
            self.calculate_question.sort_idx_doc_with_its_level(idx, result.level)

        
        self.write_log("Check there are levels not detected in paragraphs")
        self.calculate_question.handle_level_not_detected()

        
        self.write_log("index of splited docs following its level")   
        for level, questions in self.calculate_question.idx_doc_by_level.items():
            
            self.write_log(f"{level}: {questions}")   
        
        self.calculate_question.calculate_number_question_for_each_splited_docs()
        self.write_log("\nnumber of questions for each paragraph arranged in order of paragraph's index \n")
        
        for level, questions in self.calculate_question.number_question_for_each_splited_doc.items():
            self.write_log(f"level: {level}")  
            self.write_log(f"idx: {self.calculate_question.idx_doc_by_level[level]}")
            self.write_log(f"number questions: {questions}")
        self.write_log("\n")



    def generate_question_and_grade_question(self, max_attempts=5):
        #duyet qua tung level va so luong cau hoi tung level
        for level, count in self.number_question.items():
            keyword=self.lst_keyword[level]
            
            #duyet qua index cua paragraph
            for idx, idx_splited_doc in enumerate(self.calculate_question.idx_doc_by_level[level]):
                splited_doc = self.splitted_docs[idx_splited_doc].page_content
                page = self.splitted_docs[idx_splited_doc].metadata["page"]
                #so luong cau hoi cho tai lieu
                number_required_questions = self.calculate_question.number_question_for_each_splited_doc[level][idx]
                #tu khoa cua cap do 
                lst_current_questions = []   
                lst_questions_without_keywords = []
                lst_invalid_question=[]
                attempts = 0   
                self.write_log("\n")
                while len(lst_current_questions) < number_required_questions and attempts<max_attempts:                    
                    needed_question = number_required_questions - len(lst_current_questions)                
                    if attempts>0 and needed_question>0:
                        self.write_log(f"\ntao lai cau hoi level:{level}...")
                    else:
                        self.write_log(f"\ntao cau hoi level:{level}...\n")
                    
                    
                    existing_questions = "\n".join(
                        f"+{item.question}" for item in self.questions if item.idx_doc==idx_splited_doc
                    )
                    #self.write_log(f"cau hoi da co (idx_doc={idx_splited_doc}): \n{existing_questions}")

                    lst_questions_without_keywords_format_text = "\n".join(
                        f"+{item.question}" for item in lst_questions_without_keywords
                    )

                    #self.write_log(f"cau hoi khong chua tu khoa: \n{lst_questions_without_keywords_format_text}")

                    lst_invalid_question_format_text = "\n".join(
                        f"+{item.question}" for item in lst_invalid_question
                    )

                    #self.write_log(f"cau hoi khong hop le: \n{lst_invalid_question_format_text}")
                    # Create input
                    input_data = {
                        "document": splited_doc,
                        "keyword": keyword,
                        "n_question": needed_question,
                        "existing_questions": existing_questions,
                        "questions_without_keywords": lst_questions_without_keywords_format_text,
                        "invalid_questions": lst_invalid_question_format_text
                    }
                    prompt = self.generate.render_prompt(input_data)

                    # Calculate the number of characters in the generated prompt
                    num_characters_input = len(prompt)
                    
                    self.total_character_used+=num_characters_input
                    # Print the result
                    #print(f"The generated prompt input contains {num_characters_input} characters.")
                    
                    result = self.llm_generate.invoke(input_data)
                    
                    num_characters_output=len(str(result))
                    self.total_character_used+=num_characters_output
                    #print(f"The generated prompt output contains {num_characters_output} characters.") 

                    if result is None:
                        self.write_log("Khong the tao cau hoi!!!")
                    else:                       
                        self.write_log(f"Kiem tra cau hoi da ton tai hay chua...")

                        for q in result.Question:
                            
                            self.write_log(f"\nCau hoi: {q.question}")
                            if (self.is_question_in_list(q.question, self.questions)):                              
                                self.write_log(f"Cau hoi da ton tai trong danh sach tong!!!")
                            elif(self.is_question_in_list(q.question, lst_current_questions)):
                                self.write_log(f"Cau hoi da ton tai trong danh sach tam thoi!!!")
                            else:
                                self.write_log("Cau hoi chua ton tai=>Kiem tra tu khoa....")
                                matched_keyword=self.check_keyword_in_question(q.question, level)
                                self.write_log(f"Option 1: {q.options[0]}")
                                self.write_log(f"Option 2: {q.options[1]}")
                                self.write_log(f"Option 3: {q.options[2]}")
                                self.write_log(f"Option 4: {q.options[3]}")
                                self.write_log(f"Answer: {q.answer}")
                                self.write_log(f"Citation: {q.citation}")    
                                self.write_log(f"Keyword: {matched_keyword}")
                                if (matched_keyword):  
                                    self.write_log("Danh gia cau hoi....")
                                    other_questions_format_text=f"+{q.options[0]}\n+{q.options[1]}\n+{q.options[2]}\n+{q.options[3]}"                          
                                    input_data={
                                            "document": splited_doc,
                                            "question": q.question,
                                            "suggested_answer": q.answer,
                                            "other_questions":other_questions_format_text
                                    }
                                    # Get the rendered prompt
                                    prompt = self.grade.render_prompt(input_data)

                                    # Calculate the number of characters in the generated prompt
                                    num_characters = len(prompt)
                                    self.total_character_used+=num_characters
                                    # Print the result
                                    #print(f"The grade prompt input contains {num_characters} characters.")
                                    score = self.llm_grade.invoke(input_data)
                                    num_characters_output=len(str(result))
                                    self.total_character_used+=num_characters_output
                                    #print(f"The grade prompt output contains {num_characters_output} characters.")     
                                    self.write_log(f"Lien quan: {score.binary_score}")
                                    self.write_log(f"Giai thich: {score.description}") 
                                    if score.binary_score == "yes":        
                                        q.level = level
                                        q.page=page+1
                                        q.idx_doc=idx_splited_doc
                                        q.citation=splited_doc
                                        self.write_log(f"cau hoi dung: {q}")
                                        self.write_log(f"them cau hoi vao danh sach tam thoi!")
                                        lst_current_questions.append(q)
                                    elif score.binary_score == "no":                                       
                                        if (self.is_question_in_list(q.question, lst_invalid_question))==False:    
                                            lst_invalid_question.append(q)
                                else:
                                    if(self.is_question_in_list(q.question, lst_questions_without_keywords))==False:

                                        lst_questions_without_keywords.append(q)
                                
                    self.write_log(f"Tạo đủ {len(lst_current_questions)}/{number_required_questions} câu hỏi")
                    
                    self.write_log(f"Số lần tạo lại: {attempts}")

                    attempts += 1
                    if len(lst_current_questions) >= number_required_questions:
                        break   
                self.write_log(f"Them {len(lst_current_questions)} cau hoi vao danh sach tong")
                self.questions.extend(lst_current_questions)
                self.write_log(f"Tong cau hoi hien tai: {len(self.questions)}")
                self.task["current_number_question"] = len(self.questions)                         

    def check_keyword_in_question(self, question: str, level: str):
        """
        Kiểm tra xem câu hỏi có chứa từ khóa thuộc cấp độ Bloom đã cho hay không.

        Args:
            question (str): Nội dung câu hỏi
            level (str): Tên cấp độ Bloom (remember, understand, ...)

        Returns:
            boolean: true nếu có từ khóa phù hợp, false nếu không
        """
        self.write_log(f"Level: {level}")
        
        question_lower = question.lower()
        keyword_str = self.lst_keyword.get(level)
        if not keyword_str:
            self.write_log("keyword rong !!!")
            return False

        for keyword in keyword_str.split(", "):
            if keyword in question_lower:
                self.write_log(f"[{keyword}]")
                return True

        return False

    def write_log(self, content):
        with open(self.log_file_path, "a", encoding="utf-8") as f:
            f.write(content + "\n")


    def normalize(self, text: str) -> str:
    # Strip, lowercase, and remove punctuation
        return text.strip().lower().translate(str.maketrans('', '', string.punctuation))

    def is_question_in_list(self, question: str, question_list: list) -> bool:
        created_question = self.normalize(question)
        for item in question_list:
            existed_question=self.normalize(item.question)           
            if created_question == existed_question:
                self.write_log(f"Cau hoi da co: {existed_question}")
                return True
        return False
    def get_lst_question(self):
        self.split_document()
        self.detect_level_and_calculate_question()
        self.generate_question_and_grade_question()
        self.write_log(f"Tong characters: {self.total_character_used}")
        return self.questions

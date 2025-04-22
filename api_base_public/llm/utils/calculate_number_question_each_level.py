import random

class CalculateQuestion:
    def __init__(self, number_question):
        self.idx_doc_by_level = {
            "remember": [],
            "understand": [],
            "apply": [],
            "analyze": [],
            "evaluate": [],
            "create": [],
        }

        self.number_question_for_each_splited_doc = {
            "remember": [],
            "understand": [],
            "apply": [],
            "analyze": [],
            "evaluate": [],
            "create": [],
        }
        self.number_question=number_question

    #add indexes of paragraphs with its levels 
    def sort_idx_doc_with_its_level(self, idx, list_level):
        for level in list_level:            
            name = level.lower()
            if (self.number_question[name]>0): #if so luong cau hoi cua level hien tai do user nhap lon hon >0
                if name in self.idx_doc_by_level:
                    self.idx_doc_by_level[name].append(idx)

    #calculate questions for each paragraph
    def calculate_number_question_for_each_splited_docs(self):
        for level, count in self.number_question.items():
            number_splited_docs = len(self.idx_doc_by_level[level])
            if count >0 :
            # Case 1: Fewer paragraphs than needed → reuse           
                if count >= number_splited_docs:
                    print("the number of paragraphs < number of required questions")
                    distribution = [1] * number_splited_docs
                    remaining = count - number_splited_docs
                    i = 0
                    while remaining > 0:
                        distribution[i] += 1
                        remaining -= 1
                        i = (i + 1) % number_splited_docs
                    self.number_question_for_each_splited_doc[level] = distribution

                # ✅ Case 2: More paragraphs than needed → pick subset and update idx_doc_by_level
                else:
                    print("\nthe number of paragraphs>number of required questions\n")
                    shuffled_paragraphs = self.idx_doc_by_level[level].copy()                 
                    random.shuffle(shuffled_paragraphs)  # Shuffle the list in place
                    selected_paragraphs = shuffled_paragraphs[:count]  # Pick only what's needed
                    self.idx_doc_by_level[level] = selected_paragraphs    # Update to trimmed/shuffled subset
                    # Assign 1 question per selected paragraph
                    distribution = [1] * count
                    self.number_question_for_each_splited_doc[level] = distribution

    #handle if paragraphs don't have levels        
    def handle_level_not_detected(self):
        """
        Neu mot level khong co index cua doan van nho thi se lay index cua level nho hon
        """
        bloom_order = ["remember","understand", "apply", "analyze", "evaluate","create" ]
        for i, level in enumerate(bloom_order):
            if (self.number_question[level]>0):#if so luong cau hoi cua level hien tai do user nhap lon hon >0
                if not self.idx_doc_by_level[level]:  # neu level khong co idx
                    for lower_level in bloom_order[i -1:]:# tim level nho hon
                        if self.idx_doc_by_level[lower_level]:  #tim thay level no hon
                                print(f"Khong co level '{level}', thay the bang level '{lower_level}'")
                                self.idx_doc_by_level[level] = self.idx_doc_by_level[lower_level]# gan idx cua level nho hon cho level lon hon
                                break
                        else:
                            print(f"Khong tim thay level nho hon de thay the cho level '{level}'. De trong")

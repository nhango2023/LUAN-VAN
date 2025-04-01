class CalculateQuestion:
    def __init__(self):
        self.idx_doc_by_level = {
            "remember": [],
            "understand": [],
            "apply": [],
            "analyze": [],
            "evaluate": [],
            "create": [],
        }

        self.n_question_for_each_paragraph = {
            "remember": [],
            "understand": [],
            "apply": [],
            "analyze": [],
            "evaluate": [],
            "create": [],
        }

    def calculate_level(self, idx, list_level):
        for level in list_level:
            name = level.lower()
            if name in self.idx_doc_by_level:
                self.idx_doc_by_level[name].append(idx)

    def calculate_number_question_for_each_level(self, n_question, lv_name):
        n_paragraph=len(self.idx_doc_by_level[lv_name])
        if (n_paragraph>0):
            if n_question < n_paragraph:
                raise ValueError("Not enough questions to assign at least 1 to each paragraph.")

            # Start by giving each paragraph 1 question
            distribution = [1] * n_paragraph
            remaining = n_question - n_paragraph

            # Distribute remaining questions
            i = 0
            while remaining > 0:
                distribution[i] += 1
                remaining -= 1
                i = (i + 1) % n_paragraph


            if lv_name in self.n_question_for_each_paragraph:
                self.n_question_for_each_paragraph[lv_name] = distribution
            else:
                raise ValueError(f"Level name '{lv_name}' is not recognized.")
           


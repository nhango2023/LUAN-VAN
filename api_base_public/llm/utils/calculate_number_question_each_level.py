import random

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

    #add indexes of paragraphs with its levels 
    def calculate_level(self, idx, list_level):
        for level in list_level:
            name = level.lower()
            if name in self.idx_doc_by_level:
                self.idx_doc_by_level[name].append(idx)

    #calculate questions for each paragraph
    def calculate_number_question_for_each_level(self, n_question, lv_name):
        paragraphs = self.idx_doc_by_level[lv_name]
        n_paragraph = len(paragraphs)

        if n_paragraph == 0:
            raise ValueError(f"No paragraphs found for level '{lv_name}'.")

        if n_question < 1:
            raise ValueError("Number of questions must be greater than 0.")

        # ✅ Case 1: Fewer paragraphs than needed → reuse
        
        if n_question >= n_paragraph:
            print("\nthe number of paragraphs> number of required questions\n")
            distribution = [1] * n_paragraph
            remaining = n_question - n_paragraph
            i = 0
            while remaining > 0:
                distribution[i] += 1
                remaining -= 1
                i = (i + 1) % n_paragraph

            self.n_question_for_each_paragraph[lv_name] = distribution

        # ✅ Case 2: More paragraphs than needed → pick subset and update idx_doc_by_level
        else:
            print("\nthe number of paragraphs< number of required questions\n")
            shuffled_paragraphs = paragraphs.copy()
            
            random.shuffle(shuffled_paragraphs)  # Shuffle the list in place

            selected_paragraphs = shuffled_paragraphs[:n_question]  # Pick only what's needed
            self.idx_doc_by_level[lv_name] = selected_paragraphs    # Update to trimmed/shuffled subset

            # Assign 1 question per selected paragraph
            distribution = [1] * n_question
            self.n_question_for_each_paragraph[lv_name] = distribution

    #handle if paragraphs don't have levels        
    def fallback_if_empty_level(self):
            bloom_order = ["remember","understand", "apply", "analyze", "evaluate","create" ]
            for i, level in enumerate(bloom_order):
                if not self.idx_doc_by_level[level]:  # If current level has no paragraphs
                    for lower_level in bloom_order[i -1:]:
                        if self.idx_doc_by_level[lower_level]:  # Found a fallback
                            print(f"⚠️ Fallback: No paragraphs for '{level}', using '{lower_level}' instead.")
                            self.idx_doc_by_level[level] = self.idx_doc_by_level[lower_level]
                            break
                    else:
                        print(f"❌ Warning: No available fallback for '{level}'. It will remain empty.")

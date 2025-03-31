class CalculateQuestion:
    def __init__(self):
        self.level_1 = {"name": "Remember", "number": 0}
        self.level_2 = {"name": "Understand", "number": 0}
        self.level_3 = {"name": "Apply", "number": 0}
        self.level_4 = {"name": "Analyze", "number": 0}
        self.level_5 = {"name": "Evaluate", "number": 0}
        self.level_6 = {"name": "Create", "number": 0}
        pass
    
    def calcuate_level(self, list_level):
        for level in list_level:
            name = level["name"].lower()
            if name == "remember":
                self.level_1["number"] += 1
            elif name == "understand":
                self.level_2["number"] += 1
            elif name == "apply":
                self.level_3["number"] += 1
            elif name == "analyze":
                self.level_4["number"] += 1
            elif name == "evaluate":
                self.level_5["number"] += 1
            elif name == "create":
                self.level_6["number"] += 1

    def calculate_number_question_for_each_level():
        pass
# import subprocess

# if __name__ == "__main__":
#     subprocess.run([
#         "uvicorn", 
#         "app.main:app", 
#         "--host", "127.0.0.1", 
#         "--port", "55095",
#         "--reload", 
#         "--timeout-keep-alive", "600"  
#     ])

import uvicorn

if __name__ == "__main__":
    uvicorn.run("app.main:app", host="127.0.0.1", port=55095, workers=1)

# import uvicorn
# import os
# # import subprocess

# # Chạy ứng dụng FastAPI
# if __name__ == "__main__":
    
#     uvicorn.run("app.main:app", host="0.0.0.0", port=550595, reload=True)
import subprocess

if __name__ == "__main__":
    subprocess.run([
        "uvicorn", 
        "app.main:app", 
        "--host", "127.0.0.1", 
        "--port", "55095",
        "--reload", 
        "--timeout-keep-alive", "600"  
    ])

# import uvicorn

# if __name__ == "__main__":
#     uvicorn.run("app.main:app", host="0.0.0.0", port=55095, workers=2)
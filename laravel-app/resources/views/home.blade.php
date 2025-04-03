@extends("layout")
@section('content')
    <style>
        .upload-container {
            background-color: #fff;
            border: 2px dashed #ddd;
            padding: 40px;
            text-align: center;
            width: 100%;
            height: 100%;
            border-radius: 8px;
        }

        .upload-container h3 {
            margin-bottom: 20px;
        }

        .upload-container button {
            background-color: #A0A0A0;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
        }

        .upload-container p {
            margin-top: 10px;
            color: #888;
        }

        .upload-container input[type="file"] {
            display: none;
        }

        .drop-zone {
            display: inline-block;
            padding: 20px;
            border: 2px dashed #007bff;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .drop-zone:hover {
            background-color: #f1f9ff;
        }

        .drop-zone.active {
            background-color: #f1f9ff;
        }
    </style>

    


    <!-- Main Content -->
    <div class="main-container">
        <!-- Text Input Section -->
        <div class="text-input-section">

            <div class="upload-container">
                <h3>Upload Your File</h3>
                <label for="file-upload" class="drop-zone">
                    <span>Choose Files</span>
                    
                </label>
                <p>or drop files here</p>
                <p id="file-name-display" style="color: #333; font-weight: bold;"></p>
            </div>


            {{-- <textarea placeholder="Enter the text you want to convert to speech here."></textarea> --}}
        </div>

        <!-- Voice Selection Section -->
        <div class="voice-selection-section">
            <form action="{{ route('question.create') }}" method="post" enctype="multipart/form-data" >
                @csrf
                <!-- Hidden input file (vẫn có thể trigger bằng JS) -->
                <input type="file" name="file_upload" id="file-upload" style="display: none;">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">remember</label>
                        <input type="number" name="n_remember" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">remember</label>
                        <input type="number" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">understand</label>
                        <input type="number" name="n_understand" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">understand</label>
                        <input type="number" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">apply</label>
                        <input type="number" name="n_apply" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">apply</label>
                        <input type="number" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">analyze</label>
                        <input type="number" name="n_analyze" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">analyz</label>
                        <input type="number" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">evaluate</label>
                        <input type="number" name="n_evaluate" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">evaluate</label>
                        <input type="number"  class="form-control" id="inputPassword4">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">create</label>
                        <input type="number" name="n_create" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">create</label>
                        <input type="number" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Generate Question</button>
            </form>
        </div>
    </div>

    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropZone = document.querySelector('.drop-zone');
            const fileInput = document.getElementById('file-upload');
            const fileNameDisplay = document.getElementById('file-name-display'); // To show file name

            // Open file dialog when the drop zone is clicked
            dropZone.addEventListener('click', () => {
                fileInput.click(); // Trigger file input when drop zone is clicked
            });

            // Drag and drop events for the drop zone
            dropZone.addEventListener('dragover', (event) => {
                event.preventDefault(); // Prevent default to allow drop
                dropZone.classList.add('active'); // Change the background color when dragging over
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('active'); // Remove the active class when dragging leaves
            });

            dropZone.addEventListener('drop', (event) => {
                event.preventDefault();
                dropZone.classList.remove('active'); // Remove the active class when files are dropped
                const files = event.dataTransfer.files; // Get dropped files
                if (files.length > 0) {
                    fileInput.files = files; // Attach dropped files to input element
                    displayFileName(files[0]); // Display file name
                }
            });

            // Update file name display when file is selected via file input
            fileInput.addEventListener('change', () => {
                if (fileInput.files.length > 0) {
                    displayFileName(fileInput.files[0]); // Display file name
                }
            });

            // Function to display the file name
            function displayFileName(file) {
                const fileName = file.name;
                fileNameDisplay.textContent = `Uploaded File: ${fileName}`; // Show file name
            }
        });
        document.querySelector('.drop-zone').addEventListener('click', () => {
        document.getElementById('file-upload').click();
});

    </script>
    @endsection

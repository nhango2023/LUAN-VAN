<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Footer UI</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <style>
        .model-settings-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .model-settings-container h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.8rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 1rem;
            color: #333;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #007bff;
        }

        button {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            background-color: #007bff;
            color: #fff;
            font-size: 1.1rem;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="model-settings-container">
        <h2>AI Model Settings</h2>

        <!-- Form to select model and input API key -->
        <form action="" method="POST">
            @csrf

            <!-- AI Model Selection -->
            <div class="form-group">
                <label for="model_name">Select AI Model</label>
                <select name="model_name" id="model_name" class="form-control">
                    <option value="chatgpt" {{ old('model_name') == 'chatgpt' ? 'selected' : '' }}>ChatGPT</option>
                    <option value="gemini" {{ old('model_name') == 'gemini' ? 'selected' : '' }}>Gemini</option>
                    <option value="grok" {{ old('model_name') == 'grok' ? 'selected' : '' }}>Grok</option>
                </select>
            </div>

            <!-- API Key Input -->
            <div class="form-group">
                <label for="api_key">API Key</label>
                <input type="text" id="api_key" name="api_key" class="form-control" value="{{ old('api_key') }}">
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>

</body>

</html>

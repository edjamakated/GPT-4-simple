<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPT-4 Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-4">GPT-4 Chat</h1>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form id="gpt4-form">
                            <div class="mb-3">
<label for="instruction" class="form-label">Instruction</label>
<input type="text" class="form-control" id="instruction" required>
</div>
<div class="mb-3">
    <label for="message" class="form-label">Message</label>
    <input type="text" class="form-control" id="message" required>
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>
<div class="mt-4" id="response-container" style="display: none;">
    <h5>Response</h5>
    <pre id="response-text"></pre>
</div>
</div>
</div>
</div>
</div>
</div>
<script>
    $("#gpt4-form").on("submit", function (e) {
        e.preventDefault();
        const instruction = $("#instruction").val();
        const message = $("#message").val();
        const url = "path/to/your/php/script.php?instruction=" + encodeURIComponent(instruction) + "&message=" + encodeURIComponent(message);
        
        $.getJSON(url, function (data) {
            if (data.error) {
                alert("Error: " + data.error);
            } else {
                $("#response-text").text(data.response);
                $("#response-container").show();
            }
        }).fail(function () {
            alert("Error: Unable to connect to the server.");
        });
    });
</script>
</body>
</html>

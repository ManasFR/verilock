@extends('admin.layout.app')
@include('admin.navbar.header')
@section('content')

<div class="container">
    <br>
    <h3>Generate License Validation Wordpress Script</h3>
    <br>
    <button id="generate-script" class="btn btn-primary">Generate API Script</button>

    <div id="generated-script" style="margin-top: 20px;">
        <!-- Generated script will appear here -->
    </div>
</div>

<script>
    document.getElementById('generate-script').addEventListener('click', async function () {
        const responseDiv = document.getElementById('generated-script');
        try {
            const response = await fetch('{{ route('generate.api.script') }}', {
                method: 'GET',
            });

            const result = await response.json();
            if (result.success) {
                // Escape characters to display as raw code
                const script = result.script.replace(/</g, '&lt;').replace(/>/g, '&gt;');

                // Display the raw code in a pre block
                responseDiv.innerHTML = `
                <button onclick="copyToClipboard()" style="padding:10px; border:1px solid black; border-radius:5px;background:white;"><i class="fas fa-copy"></i></button>
                    <pre style="background-color: #f4f4f4; padding: 10px; border-radius: 5px; white-space: pre-wrap; word-wrap: break-word;">
                        ${script}
                    </pre>
                `;
            } else {
                responseDiv.textContent = 'Failed to generate the script.';
            }
        } catch (error) {
            responseDiv.textContent = 'Error: Unable to generate the script.';
        }
    });

    // Function to copy the script
    function copyToClipboard() {
        const scriptText = document.querySelector('#generated-script pre').textContent;
        navigator.clipboard.writeText(scriptText).then(function() {
            alert('Script copied to clipboard!');
        }, function(err) {
            alert('Failed to copy script: ', err);
        });
    }
</script>

@endsection

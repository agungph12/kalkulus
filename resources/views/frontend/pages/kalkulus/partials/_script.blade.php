<script>
    $('.select2').select2({
        theme: 'bootstrap-5'
    });

    document.getElementById('calcForm').addEventListener('submit', function(e) {
        e.preventDefault();

        document.getElementById('spinner').classList.remove('d-none');
        document.getElementById('calculateBtn').disabled = true;

        setTimeout(function() {
            let equation = document.getElementById('equationInput').value;
            let calculationType = document.getElementById('calculationType').value;
            let formData = new FormData();
            formData.append('equation', equation);
            formData.append('type', calculationType);
            formData.append('_token', '{{ csrf_token() }}');

            function simulateTyping(text, elementId, speed = 50) {
                let i = 0;
                const interval = setInterval(() => {
                    if (i < text.length) {
                        if (text.charAt(i) === '\n') {
                            document.getElementById(elementId).innerHTML += '<br>';
                        } else {
                            document.getElementById(elementId).innerHTML += text.charAt(i);
                        }
                        i++;
                    } else {
                        clearInterval(interval);
                    }
                }, speed);
            }

            fetch('{{ route('store') }}', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    const resultDiv = document.getElementById('result');
                    resultDiv.innerHTML = '';
                    resultDiv.style.display = 'block';
                    document.getElementById('spinner').classList.add('d-none');
                    document.getElementById('calculateBtn').disabled = false;

                    let cleanResult = data.result.replace(/<br>/g, "\n");
                    simulateTyping(cleanResult, 'result', 50);
                })
                .catch(error => console.error('Error:', error))
                .finally(() => {
                    document.getElementById('spinner').classList.add('d-none');
                    document.getElementById('calculateBtn').disabled = false;
                });
        }, 3000);
    });
</script>

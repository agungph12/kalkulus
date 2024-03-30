@extends('calculator.layouts.app')

@section('title')
    Kalkulus Kalkulator
@endsection

@section('_konten_')
    <div class="container my-5">
        <h2 class="mb-4">@yield('title')</h2>
        <form id="calcForm">
            @csrf
            <div class="mb-3">
                <label for="desc" class="form-label">Support :</label><br>
                <small class="text-success">1. Persamaan Linear & Kuadrat</small><br>
                <small class="text-danger">2. Pertidaksamaan Linear & Kuadrat ( On Progress )</small>
            </div>
            <div class="mb-3">
                <label for="equationInput" class="form-label">Masukkan Soalnya :</label>
                <input type="text" class="form-control" id="equationInput" name="equation"
                    placeholder="Contoh : 3, -9 ( 3x - 9 = 0 )">
            </div>
            <div class="mb-3">
                <label for="calculationType" class="form-label">Pilih Tipe Perhitungan :</label>
                <select class="form-select select2" id="calculationType" name="type">
                    <option value="equation">Persamaan Linear & Kuadrat</option>
                    <option value="inquality" disabled>Pertidaksamaan Linear & Kuadrat</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" id="calculateBtn">
                <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status"
                    aria-hidden="true"></span>
                Hitung Sekarang
            </button>
        </form>
        <div id="result" class="mt-4"></div>
    </div>
@endsection

@push('addScript')
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
@endpush

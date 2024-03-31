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
        <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        Hitung Sekarang
    </button>
</form>

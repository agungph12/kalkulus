<div class="table-responsive mt-5">
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Soal</th>
                <th>Jawaban</th>
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($menghitung as $item)
                <tr>
                    <td>
                        {{ ($menghitung->currentPage() - 1) * $menghitung->perPage() + $loop->iteration }}
                    </td>
                    <td>
                        {{ $item->equation }}
                    </td>
                    <td>
                        <a href="" class="btn btn-success btn-sm text-white">Lihat Jawaban</a>
                    </td>
                    <td>
                        {{ $item->created_at->format('d/m/Y') }}
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="12">
                        Tidak Ada Data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

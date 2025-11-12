<div class="flex items-center gap-3 mb-6 mt-10">
    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V9a4 4 0 00-8 0v4m-9 4h18v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2z" />
        </svg>
    </div>
    <h2 class="font-bold text-xl">Alamat Pengiriman & Ongkir</h2>
</div>
<div class="bg-white border border-[#E5E5E5] rounded-[15px] p-6 md:p-8 mt-8">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
        <!-- Provinsi -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Provinsi Tujuan</label>
            <select id="province" name="province_id"
                class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 bg-gray-50 focus:ring-2 focus:ring-secondary focus:border-transparent focus:outline-none transition-all duration-300">
                <option value="">-- Memuat Provinsi --</option>
            </select>
        </div>

        <!-- Kota -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Kota / Kabupaten</label>
            <select id="city" name="city_id"
                class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 bg-gray-50 focus:ring-2 focus:ring-secondary focus:border-transparent focus:outline-none transition-all duration-300">
                <option value="">-- Pilih Kota / Kabupaten --</option>
            </select>
        </div>

        <!-- Kecamatan -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan</label>
            <select id="district" name="district_id"
                class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 bg-gray-50 focus:ring-2 focus:ring-secondary focus:border-transparent focus:outline-none transition-all duration-300">
                <option value="">-- Pilih Kecamatan --</option>
            </select>
        </div>

        <!-- Berat -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Total Berat Barang (gram)</label>
            <input type="number" id="weight" name="weight" value="{{ $totalWeight }}" readonly
                class="w-full border border-[#E5E5E5] rounded-[15px] px-5 py-3 bg-gray-100 focus:ring-2 focus:ring-secondary focus:border-transparent focus:outline-none transition-all duration-300" />
            <p class="text-xs text-gray-500 mt-1">*otomatis dihitung dari total produk di keranjang</p>
        </div>

    </div>

    <!-- Pilihan Kurir -->
    <div class="mb-8">
        <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Kurir</label>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @php
            $couriers = ['sicepat','jnt','ninja','jne','anteraja'];
            @endphp
            @foreach($couriers as $index => $courier)
            <label for="courier-{{ $index }}" class="flex items-center gap-2 cursor-pointer border border-[#E5E5E5] rounded-[12px] px-4 py-3 bg-gray-50 hover:bg-gray-100 transition">
                <input type="radio" id="courier-{{ $index }}" name="courier" value="{{ $courier }}"
                    class="text-primary focus:ring-primary focus:ring-offset-0">
                <span class="text-sm font-medium uppercase text-gray-800">{{ $courier }}</span>
            </label>
            @endforeach
        </div>
    </div>

    <!-- Tombol & Loader -->
    <div class="flex flex-col items-center justify-center mb-8">
        <button type="button"
            class="btn-check w-full md:w-auto px-8 py-4 rounded-full text-white font-semibold bg-primary hover:bg-primary/90 transition-all duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:opacity-50 disabled:cursor-not-allowed">
            Hitung Ongkos Kirim
        </button>
        <div id="loading-indicator" class="hidden border-4 border-gray-200 border-t-primary rounded-full w-8 h-8 animate-spin mt-4"></div>
    </div>

    <!-- Hasil Ongkir -->
    <div class="results-container hidden mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Hasil Perhitungan Ongkir</h3>
        <div id="results-ongkir" class="space-y-3"></div>
    </div>
</div>

{{-- Script AJAX --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(function() {
        const token = $('meta[name="csrf-token"]').attr('content');

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        // Load provinsi
        $.getJSON('/provinces', function(response) {
            $('#province').html('<option value="">-- Pilih Provinsi --</option>');
            $.each(response, function(_, v) {
                $('#province').append(`<option value="${v.id}">${v.name}</option>`);
            });
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Error loading provinces:', textStatus, errorThrown);
            $('#province').html('<option value="">-- Gagal memuat provinsi. Coba refresh halaman. --</option>');
            // Opsional: Tampilkan toast atau alert
            alert('Data provinsi tidak dapat dimuat. API mungkin sedang down. Silakan coba lagi dalam beberapa menit.');
        });

        // Provinsi -> Kota
        $('#province').on('change', function() {
            let id = $(this).val();
            $('#city').html('<option>Memuat kota...</option>').prop('disabled', true);
            $('#district').html('<option>-- Pilih Kecamatan --</option>').prop('disabled', true);

            if (id) {
                $.getJSON(`/cities/${id}`, function(response) {
                    $('#city').html('<option value="">-- Pilih Kota / Kabupaten --</option>');
                    $.each(response, function(_, v) {
                        $('#city').append(`<option value="${v.id}">${v.name}</option>`);
                    });
                    $('#city').prop('disabled', false);
                });
            }
        });

        // Kota -> Kecamatan
        $('#city').on('change', function() {
            let id = $(this).val();
            $('#district').html('<option>Memuat kecamatan...</option>').prop('disabled', true);

            if (id) {
                $.getJSON(`/districts/${id}`, function(response) {
                    $('#district').html('<option value="">-- Pilih Kecamatan --</option>');
                    $.each(response, function(_, v) {
                        $('#district').append(`<option value="${v.id}">${v.name}</option>`);
                    });
                    $('#district').prop('disabled', false);
                });
            }
        });

        // Hitung ongkir
        $(document).ready(function() {
            const token = $('meta[name="csrf-token"]').attr('content');

            // Fungsi format rupiah
            function formatCurrency(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(number);
            }

            // Hitung ongkir
            $('.btn-check').on('click', function(e) {
                e.preventDefault();

                const district_id = $('#district').val();
                const courier = $('input[name="courier"]:checked').val();
                const weight = $('#weight').val();

                if (!district_id || !courier || !weight) {
                    alert('Harap lengkapi semua data pengiriman!');
                    return;
                }

                // Loading
                $('#loading-indicator').show();
                $('.btn-check').prop('disabled', true).text('Memproses...');

                $.ajax({
                    url: '/check-ongkir',
                    method: 'POST',
                    data: {
                        _token: token,
                        district_id: district_id,
                        courier: courier,
                        weight: weight,
                    },
                    success: function(res) {
                        $('#results-ongkir').empty();
                        $('.results-container').removeClass('hidden');

                        if (res.length > 0) {
                            $.each(res, function(_, v) {
                                $('#results-ongkir').append(`
                            <div class="select-shipping flex justify-between items-center p-4 bg-gray-50 border border-[#E5E5E5] rounded-[12px] shadow-sm cursor-pointer hover:border-indigo-500 transition"
                                 data-cost="${v.cost}">
                                <span class="text-sm font-medium text-gray-700">
                                    ${v.service} - ${v.description} (${v.etd})
                                </span>
                                <span class="text-sm font-semibold text-primary">
                                    ${formatCurrency(v.cost)}
                                </span>
                            </div>
                        `);
                            });
                        } else {
                            $('#results-ongkir').html('<p class="text-center text-gray-500">Tidak ada data ongkir ditemukan.</p>');
                        }

                        // Klik salah satu hasil ongkir
                        $('.select-shipping').on('click', function() {
                            const ongkir = $(this).data('cost');
                            const subtotal = parseFloat($('#subtotal').data('value')) || 0;
                            const total = subtotal + ongkir;

                            // Tandai pilihan aktif
                            $('.select-shipping').removeClass('border-indigo-500 bg-indigo-50');
                            $(this).addClass('border-indigo-500 bg-indigo-50');

                            // Update tampilan total di ringkasan
                            $('#shipping-amount').text(formatCurrency(ongkir));
                            $('#total-amount').text(formatCurrency(total));

                            alert('Ongkir terpilih: ' + formatCurrency(ongkir));
                        });
                    },
                    error: function(xhr) {
                        console.error('Error Response:', xhr.responseText);
                        alert('Terjadi kesalahan saat menghitung ongkir. Cek console.');
                    },
                    complete: function() {
                        $('#loading-indicator').hide();
                        $('.btn-check').prop('disabled', false).text('Hitung Ongkos Kirim');
                    }
                });
            });
        });
    });
</script>
@if (!isset($noWrapper) || !$noWrapper)
    <div class="{{ $colClass ?? 'col-5 col-lg-5 col-md-5' }} px-2">
@endif
    <div class="card" id="kalenderSection">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center text-center">
                    <div>
                        <h5 class="mb-1">{{ $selectedSpm->nama_spm ?? 'Tidak ada data' }}</h5>
                        <small class="text-muted">
                            @if (($isAdminMutu ?? false) && isset($selectedSpm->nama_unit))
                                {{ $selectedSpm->nama_unit }} -
                            @endif
                            {{ $kalenderData['bulanNama'] ?? '' }}
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="calendar-grid border-0 shadow-sm rounded-3">
                    @foreach (['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $hari)
                        <div class="calendar-header">{{ $hari }}</div>
                    @endforeach

                    @for ($i = 0; $i < $kalenderData['skip']; $i++)
                        <div class="calendar-day bg-light"></div>
                    @endfor

                    @for ($d = 1; $d <= $kalenderData['daysInMonth']; $d++)
                        @php
                            $tglFull = Carbon\Carbon::create($tahun, $bulan, $d)->format('Y-m-d');
                            $isToday = $tglFull == date('Y-m-d');
                            $pengisian = $kalenderData['dataPengisian']->get($tglFull);
                            $sudahIsi = $pengisian !== null;

                            // Custom attribute for different logic in views if needed
                            $onClick = $onClickAction ?? 'handleDateClick';
                        @endphp

                        <div class="calendar-day"
                            onclick="{{ $onClick }}(
                                '{{ $tglFull }}',
                                {{ $sudahIsi ? 'true' : 'false' }},
                                {{ $sudahIsi ? $pengisian->id : 'null' }})"
                            style="cursor:pointer">
                            <span class="{{ $isToday ? 'today-highlight' : '' }}">{{ $d }}</span>

                            <div class="d-block mt-1 text-center">
                                @if ($sudahIsi)
                                    <span class="dot bg-success d-block mx-auto mb-1"></span>
                                    <small class="text-muted fw-semibold" style="font-size: 0.75rem;">
                                        @php
                                            $num = (float)$pengisian->numerator;
                                            $den = (float)$pengisian->denominator;
                                            $fmtNum = (floor($num) == $num) ? number_format($num, 0, ',', '.') : rtrim(rtrim(number_format($num, 2, ',', '.'), '0'), ',');
                                            $fmtDen = (floor($den) == $den) ? number_format($den, 0, ',', '.') : rtrim(rtrim(number_format($den, 2, ',', '.'), '0'), ',');
                                        @endphp
                                        {{ $fmtNum }} / {{ $fmtDen }}
                                    </small>
                                @else
                                    <span class="dot border d-block mx-auto"></span>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    @if (!isset($noWrapper) || !$noWrapper)
        </div>
    @endif

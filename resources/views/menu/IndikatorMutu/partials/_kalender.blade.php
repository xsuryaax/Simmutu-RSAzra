@if ($kalenderData)
    <div class="{{ $colClass ?? 'col-5 col-lg-5 col-md-5' }} px-2">
        <div class="card" id="kalenderSection">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center text-center">
                    <div>
                        <h5 class="mb-1">{{ $selectedIndikator->nama_indikator }}</h5>
                        <small class="text-muted">
                            @if ($isAdminMutu)
                                {{ $selectedIndikator->nama_unit }} -
                            @endif
                            {{ $kalenderData['bulanNama'] }}
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
                                        {{ $pengisian->numerator }} / {{ $pengisian->denominator }}
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
    </div>
@endif

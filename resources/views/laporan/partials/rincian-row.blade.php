<tr data-level="{{ $level }}" data-parent="{{ $parent ?? '' }}">
    {{-- <td>
        @if (!empty($rincian['children']))
            <button type="button" class="btn btn-sm btn-link toggle-child" data-target="{{ $rincian['kode'] }}">
                <i class="bi bi-caret-right-fill"></i>
            </button>
        @else
            <span style="margin-left: {{ $level * 20 }}px;"></span>
        @endif
        {{ $rincian['kode'] }}
    </td>

    <td>{!! $rincian['uraian'] !!}</td> --}}
    <td>
        {{-- tampilkan kode hanya jika ini level pertama --}}
        @if (isset($rincian['children']) && count($rincian['children']) > 0)
            {{ $rincian['kode'] }}
        @endif
    </td>
    <td class="td-uraian">
        @if(empty($rincian['children']))
            <span class="subtext">{{ $rincian['uraian'] }}</span>
        @else
            <strong>{{ $rincian['uraian'] }}</strong>
        @endif
    </td>
    <td class="text-center">{{ $rincian['koefisien'] ?? '' }}</td>
    <td class="text-center">{{ $rincian['satuan'] ?? '' }}</td>
    <td class="text-end">{{ number_format($rincian['harga'] ?? 0, 0, ',', '.') }}</td>
    <td class="text-end">{{ number_format($rincian['jumlah'] ?? 0, 0, ',', '.') }}</td>
    <td class="text-center">
        @if($active_lock->is_locked == 1)
            <span class="badge bg-secondary">
                <i class="bi bi-lock-fill"></i>
            </span>
        @else
            @if (isset($rincian['id']))
                <button class="btn btn-warning btn-sm editRincian" data-id="{{ $rincian['id'] }}">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-danger btn-sm deleteRincian" data-id="{{ $rincian['id'] }}">
                    <i class="bi bi-trash"></i>
                </button>
            @endif
        @endif
    </td>
</tr>

@if (!empty($rincian['children']))
    @foreach ($rincian['children'] as $child)
        @include('laporan.partials.rincian-row', [
            'rincian' => $child,
            'level' => $level + 1,
            'parent' => $rincian['kode'],
        ])
    @endforeach
@endif

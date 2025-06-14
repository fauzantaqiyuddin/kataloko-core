@if (auth()->user()->isMstd())
    <li class="pc-item pc-caption">
        <label>Approval MSTD</label>
        <i class="ti ti-dashboard"></i>
    </li>
    <li class="pc-item">
        <a href="{{ route('v1.approval.mstd.index') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-simcard-2"></use>
                </svg>
            </span>
            <span class="pc-mtext">Approval OPL</span>
        </a>
    </li>
@endif

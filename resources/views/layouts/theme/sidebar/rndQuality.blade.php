 @if (auth()->user()->isRndQuality())
     <li class="pc-item pc-caption">
         <label>Menu Rnd Quality</label>
         <i class="ti ti-dashboard"></i>
     </li>
     <li class="pc-item">
         <a href="{{ route('v1.teamRnD.index') }}" class="pc-link">
             <span class="pc-micon">
                 <svg class="pc-icon">
                     <use xlink:href="#custom-simcard-2"></use>
                 </svg>
             </span>
             <span class="pc-mtext">Master OPL RnD</span>
         </a>
     </li>
 @endif

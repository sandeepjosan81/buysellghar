<div class="sidebar">
  <div class="accordion accordion-flush">
  <?php
    // echo "<pre>";
    // print_r($menuLinks);
    // echo "</pre>";
    // exit;
  ?>
    @foreach($menuLinks as $index => $menuLink)
      @if(isset($menuLink['type']) && $menuLink['type'] == 'divider')
        <div class="px-3 mt-4">
          <div class="text-secondary small opacity-75 mb-2">{{ $menuLink['title'] }}</div>
          <hr class="dropdown-divider mt-0 mb-2">
        </div>
      @else
        <div class="accordion-item-{{ $index }}">
          @if(!isset($menuLink['has_children']) || !$menuLink['has_children'])
            @if (!auth()->user()->hasAnyRole(['Seller']))
              @if(($menuLink['url'] ?? ''))
                <a class="accordion-button {{ $menuLink['active'] ? '' : 'collapsed' }}" href="{{ $menuLink['url'] }}">
                  <span class="icon"><i
                      class="bi {{ $menuLink['icon'] ?? 'bi-house' }}"></i></span> {{ $menuLink['title'] }}
                </a>
              @endif
            @endif
          @else
            <h2 class="accordion-header class_{{ $menuLink['title'] }}">
              <button
                class="accordion-button {{ $menuLink['active'] ? '' : (system_setting('expand') ? '' : 'collapsed') }}"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseOne-{{ $index }}"
                aria-expanded="{{ $menuLink['active'] ? 'true' : 'false' }}"
                aria-controls="flush-collapseOne-{{ $index }}">
              <span class="icon"><i
                  class="bi {{ $menuLink['icon'] ?? 'bi-house' }}"></i></span> {{ $menuLink['title'] }}
              </button>
            </h2>
            <div id="flush-collapseOne-{{ $index }}"
                 class="accordion-collapse collapse {{ $menuLink['active'] ? 'show' : (system_setting('expand') ? 'show' : '') }}"
                 data-bs-parent="#sidebar-parent">
              <div class="accordion-body p-0">
                <ul class="nav flex-column">
                  @foreach($menuLink['children'] as $child)
                  @php
                  $childClass = str_replace(" ",'', $child['title']);

                  @endphp
                      @if(!in_array($child['title'], ["Billing","Marketing","Order Fees","Language","Translation","Intelli","Social"])) 
                      <li class="nav-item sub_class_{{ $childClass }}">
                        <a href="{{ $child['url'] }}" @if($child['blank'] ?? false) target="_blank" @endif
                        class="nav-link {{ $child['active'] ? 'active' : '' }}">{{ $child['title'] }}</a>
                      </li>
                       @endif 
                  @endforeach
                </ul>
              </div>
            </div>
          @endif
        </div>
      @endif
    @endforeach
  </div>
</div>

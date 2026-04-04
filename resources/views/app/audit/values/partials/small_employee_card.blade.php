<style>
    #cad_view_image {
        width: 350px;
        height: 350px;
        position: fixed;     /* Fixed to the screen, not the page */
        z-index: 99999;      /* Ensure it is on the very top layer */
        pointer-events: none; /* VERY IMPORTANT: Mouse ignores this box */
        display: none;       /* Start hidden */
        background: #fff;
        border: 6px solid white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        overflow: hidden;
    }

    #cad_view_image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #cad_view_image .initials-preview {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 900;
        font-size: 6rem;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    }
</style>

<div class="d-flex align-items-center gap-3">
    <div class="position-relative flex-shrink-0">
        <div class="position-relative flex-shrink-0">
            @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                <img src="{{ Storage::url($employee->photo) }}"
                     class="img-hover-preview rounded-circle border border-2 border-white shadow-sm object-fit-cover"
                     data-full-src="{{ Storage::url($employee->photo) }}"
                     width="45" height="45">
            @else
                <div class="img-hover-preview rounded-circle border border-2 border-white shadow-sm d-flex align-items-center justify-content-center text-white fw-bold"
                     data-initials="{{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}"
                     style="width:45px; height:45px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); font-size: 0.85rem;">
                    {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
                </div>
            @endif
        </div>

        <span class="position-absolute bottom-0 end-0 rounded-circle border border-2 border-white {{ $employee->gender == 'M' ? 'bg-primary' : 'bg-danger' }}"
              style="width: 12px; height: 12px;"
              title="{{ $employee->gender == 'M' ? 'Homme' : 'Femme' }}">
            </span>
    </div>

    <div class="lh-sm">
        <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.9rem;">
            {{ $employee->firstname }} <span class="text-primary text-uppercase">{{ $employee->lastname }}</span>
        </h6>
        <div class="d-flex align-items-center gap-2 mt-1">
            <small class="text-secondary fw-medium" style="font-size: 0.75rem; direction: rtl;">
                {{ $employee->firstname_arab }} {{ $employee->lastname_arab }}
            </small>
            <span class="text-muted opacity-50" style="font-size: 0.7rem;">• ID: {{ $employee->id }}</span>
        </div>
    </div>
</div>

<div id="cad_view_image"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const targetDiv = document.getElementById('cad_view_image');

        // We use event delegation to ensure it works even if rows are dynamic
        document.addEventListener('mouseover', function(e) {
            const hoverEl = e.target.closest('.img-hover-preview');

            if (hoverEl) {
                const imgSrc = hoverEl.getAttribute('data-full-src');
                const initials = hoverEl.getAttribute('data-initials');

                if (imgSrc) {
                    targetDiv.innerHTML = `<img src="${imgSrc}">`;
                } else if (initials) {
                    targetDiv.innerHTML = `<div class="initials-preview">${initials}</div>`;
                }
                targetDiv.style.display = 'block';
            }
        });

        document.addEventListener('mousemove', function(e) {
            if (targetDiv.style.display === 'block') {
                const offset = 20;
                // Use clientX/Y for position: fixed
                targetDiv.style.left = (e.clientX + offset) + 'px';
                targetDiv.style.top = (e.clientY + offset) + 'px';
            }
        });

        document.addEventListener('mouseout', function(e) {
            if (e.target.closest('.img-hover-preview')) {
                targetDiv.style.display = 'none';
                targetDiv.innerHTML = '';
            }
        });
    });
</script>

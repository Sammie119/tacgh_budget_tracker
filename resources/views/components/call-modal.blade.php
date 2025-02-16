{{-- @props(['size']) --}}
<div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {{-- @include('forms.create') --}}
            </div>

            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div> --}}
        </div>
    </div>
</div>

<script>
    const exampleModal = document.getElementById('exampleModal')
    if (exampleModal) {
        exampleModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget

            // Ajax Request
            const url = button.getAttribute('data-bs-url')
            $.get(`${url}`, function(result) {
                $(".modal-body").html(result);
            })

            // Set Modal title
            const recipient = button.getAttribute('data-bs-title')
            const modalTitle = exampleModal.querySelector('.modal-title')
            modalTitle.textContent = `${recipient}`

            // Set Modal Size
            const size = button.getAttribute('data-bs-size') //modal-xl, modal-lg
            const setSize = exampleModal.querySelector(".modal-dialog");
            setSize.setAttribute("class", `modal-dialog modal-dialog-centered modal-dialog-scrollable ${size}`);
        })
    }
</script>

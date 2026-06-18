<!-- Shared delete confirmation modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="d-flex gap-3">
                    <span class="modal-icon" style="background:#fdecec;color:#e5484d"><i class="fas fa-trash-can"></i></span>
                    <div>
                        <h5 class="modal-title mb-1" id="deleteModalLabel">Delete this record?</h5>
                        You're about to delete <strong class="text-dark" id="deleteItemName">this record</strong>.
                        This action cannot be undone.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-xmark"></i> Cancel
                </button>
                <form id="deleteForm" method="POST" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const deleteModal = document.getElementById('deleteModal');
        if (!deleteModal) return;
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const action = trigger.getAttribute('data-action');
            const name = trigger.getAttribute('data-name') || 'this record';
            document.getElementById('deleteForm').setAttribute('action', action);
            document.getElementById('deleteItemName').textContent = name;
        });
    })();
</script>
@endpush

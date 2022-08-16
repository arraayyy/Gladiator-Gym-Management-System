<!-- ADD TRAINER MODAL -->
<div class="modal fade" id="addTrainerModal" tabindex="-1" aria-labelledby="addTrainerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTrainerModalLabel">Trainer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="inserttrainer.php" method="POST" id="manage-trainer">
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        Trainer Form
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="trainerid">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" name="name" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="email" class="form-control" name="email" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Contact</label>
                            <input type="text" class="form-control" name="contact" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Rate</label>
                            <input type="number" class="form-control text-right" name="rate" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="savetrainer" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

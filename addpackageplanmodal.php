<!-- ADD PACKAGE MODAL -->
<div class="modal fade" id="addPackagePlanModal" tabindex="-1" aria-labelledby="addPackagePlanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPackagePlanModalLabel">Package Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="insertpackageplan.php" method="POST" id="manage-package-plan">
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        Package Plan Form
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="ppid">
                        <div class="form-group">
                            <label class="control-label">Package Plan Name</label>
                            <input type="text" class="form-control" name="package_plan" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Number of Days</label>
                            <input type="number" class="form-control" name="numdays" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <textarea class="form-control" cols="30" rows='3' name="description" autocomplete="off"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Amount</label>
                            <input type="number" class="form-control text-right" step="any" min="0" name="amount" autocomplete="off">
                        </div>
                    </div>		
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="savepp" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
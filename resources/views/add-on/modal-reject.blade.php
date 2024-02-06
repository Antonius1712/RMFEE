<!-- Modal Reject -->
<div id="ModalReject" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <!-- Modal Content-->
        <div class="modal-content">
            <form id="form-reject-budget" action="" method="get" style="width: 100%;">
                {{ csrf_field() }}
                <div class="modal-header" style="background-color:white;">
                    <h2 class="modal-title font-weight-bold">Reject this?</h2>
                </div>
                <div class="modal-body">
                    <p>Once you reject this, the maker still can do approval again.</p>
                    <input type="text" name="comment" id="comment" class="form-control"
                        placeholder="Additional Note">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary radius" data-dismiss="modal"
                        style="width: 50%;">Cancel</button>

                    <button type="submit" class="btn btn-primary radius" style="width: 50%;">Reject</button>

                </div>
            </form>
        </div>
    </div>
</div>

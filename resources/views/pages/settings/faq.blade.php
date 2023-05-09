<!-- Modal -->
<div class="modal fade" id="faq_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="wid">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white font-18 font-weight-bold">Help</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body pb-4">
                @include('pages.faq.faqs')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

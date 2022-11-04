<div class="modal fade" id="dialogRegistration" tabindex="-1" role="dialog" aria-labelledby="dialogRegistrationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dialogRegistrationLabel">{REGISTRATION}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label for="e-mail" class="input-group-text">{E_MAIL}:</label>
                        <input type="text" class="form-control" name="e-mail" id="e-mail" placeholder="{E_MAIL}">
                    </div>
                    <div class="input-group mb-3">
                        <label for="password" class="input-group-text">{PASSWORD}:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="{PASSWORD}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{CLOSE}</button>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary load-container" data-params='{"container":"dialogContainer","content":"dialogLogIn"}' name="login" data-bs-dismiss="modal">{LOG_IN}</button>
                        <button type="button" class="btn btn-outline-success send-form" data-params='{"action":"userRegistration"}' name="registration">{REGISTER}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
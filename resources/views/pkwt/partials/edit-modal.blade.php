<div id="bootstrapModalWrapper">

    {{-- ===================== --}}
    {{-- MODAL (BOOTSTRAP ONLY FOR THIS COMPONENT) --}}
    {{-- ===================== --}}
    <div class="modal fade"
         id="editPkwtModal"
         tabindex="-1"
         aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 rounded-4 shadow-lg">

                {{-- HEADER --}}
                <div class="modal-header border-0 px-4 pt-4">

                    <div>
                        <h5 class="modal-title fw-bold">
                            Edit PKWT
                        </h5>

                        <small class="text-muted">
                            Update employee contract information
                        </small>
                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                {{-- FORM --}}
                <form id="editPkwtForm"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="modal-body px-4">

                        {{-- EMPLOYEE --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Employee
                            </label>

                            <select name="employee_id"
                                    id="employee_id"
                                    class="form-select">

                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->name }} - {{ $employee->position }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="row g-4">

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Contract Number
                                </label>

                                <input type="text"
                                       name="contract_number"
                                       id="contract_number"
                                       class="form-control">

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Company
                                </label>

                                <input type="text"
                                       name="company"
                                       id="company"
                                       class="form-control">

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Start Date
                                </label>

                                <input type="date"
                                       name="start_date"
                                       id="start_date"
                                       class="form-control">

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    End Date
                                </label>

                                <input type="date"
                                       name="end_date"
                                       id="end_date"
                                       class="form-control">

                            </div>

                        </div>

                        <div class="mt-4">

                            <label class="form-label fw-semibold">
                                File PKWT
                            </label>

                            <input type="file"
                                   name="file_path"
                                   class="form-control">

                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti file.
                            </small>

                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="modal-footer border-0 px-4 pb-4">

                        <button type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn text-white px-4"
                                style="background-color:#3DB5FF;">

                            Save Changes

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

{{-- ===================== --}}
{{-- BOOTSTRAP JS (WAJIB GLOBAL SEKALI SAJA) --}}
{{-- TARUH DI APP.BLADE, BUKAN DI MODAL --}}
{{-- ===================== --}}
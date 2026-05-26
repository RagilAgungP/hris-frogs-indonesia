<script>

let bootstrapCssLoaded = false;

function loadBootstrapCSS() {

    if (bootstrapCssLoaded) return;

    const link = document.createElement('link');

    link.rel = 'stylesheet';

    link.href =
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css';

    link.id = 'bootstrap-modal-css';

    document.head.appendChild(link);

    bootstrapCssLoaded = true;
}

function openEditModal(id) {

    loadBootstrapCSS();

    fetch(`/pkwt/${id}/json`)
        .then(res => res.json())
        .then(data => {

            document.getElementById('editPkwtForm')
                .action = `/pkwt/${data.id}`;

            document.getElementById('employee_id')
                .value = data.employee_id ?? '';

            document.getElementById('contract_number')
                .value = data.contract_number ?? '';

            document.getElementById('company')
                .value = data.company ?? '';

            document.getElementById('start_date')
                .value = data.start_date ?? '';

            document.getElementById('end_date')
                .value = data.end_date ?? '';

            const modal = new bootstrap.Modal(
                document.getElementById('editPkwtModal')
            );

            modal.show();
        });
}

document.addEventListener('DOMContentLoaded', () => {

    const modalElement =
        document.getElementById('editPkwtModal');

    if (!modalElement) return;

    modalElement.addEventListener('hidden.bs.modal', () => {

        const css =
            document.getElementById('bootstrap-modal-css');

        if (css) {

            css.remove();

            bootstrapCssLoaded = false;
        }
    });
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
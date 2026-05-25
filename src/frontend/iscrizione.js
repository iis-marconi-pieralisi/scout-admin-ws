const API_ISCRIZIONE = '/api/iscrizione';
let iscrizioneFormMode = 'create';

function renderIscrizioni(items) {
    const tableBody = getById('iscrizioneTableBody');
    if (!tableBody) return;

    if (!Array.isArray(items) || items.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="7">Nessuna iscrizione trovata.</td></tr>';
        return;
    }

    tableBody.innerHTML = items.map(item => {
        return `
            <tr>
                <td>${escapeHtml(item.anno_associativo)}</td>
                <td>${escapeHtml(item.approvazione_capo)}</td>
                <td>${escapeHtml(item.id_persona)}</td>
                <td>${escapeHtml(item.id_pagamento)}</td>
                <td>${escapeHtml(item.id_unita)}</td>
                <td>${escapeHtml(item.id_iter)}</td>
                <td>
                    <button class="button is-small is-info" type="button" onclick="loadIscrizione('${escapeAttr(item.anno_associativo)}', '${escapeAttr(item.id_persona)}', '${escapeAttr(item.approvazione_capo)}', '${escapeAttr(item.id_pagamento)}', '${escapeAttr(item.id_unita)}', '${escapeAttr(item.id_iter)}')">Modifica</button>
                    <button class="button is-small is-danger ml-2" type="button" onclick="deleteIscrizioneRow('${escapeAttr(item.anno_associativo)}', '${escapeAttr(item.id_persona)}')">Elimina</button>
                </td>
            </tr>
        `;
    }).join('');
}

function setIscrizioneFormMode(mode) {
    iscrizioneFormMode = mode === 'edit' ? 'edit' : 'create';
    const title = getById('iscrizioneFormTitle');
    const submitButton = getById('iscrizioneSubmitButton');

    if (title) {
        title.textContent = iscrizioneFormMode === 'edit' ? 'Modifica iscrizione' : 'Crea iscrizione';
    }
    if (submitButton) {
        submitButton.textContent = iscrizioneFormMode === 'edit' ? 'Modifica' : 'Crea';
        submitButton.className = iscrizioneFormMode === 'edit' ? 'button is-info' : 'button is-primary';
    }
}

function loadIscrizione(anno, idPersona, approvazione, idPagamento, idUnita, idIter) {
    setValue('iscrizioneAnno', anno);
    setValue('iscrizioneIdPersona', idPersona);
    setChecked('iscrizioneApprovazioneCapo', approvazione === '1' || approvazione === 'true' || approvazione === true);
    setValue('iscrizioneIdPagamento', idPagamento);
    setValue('iscrizioneIdUnita', idUnita);
    setValue('iscrizioneIdIter', idIter);
    setIscrizioneFormMode('edit');
    showResponse({ info: `Iscrizione caricata: ${anno} / ${idPersona}` });
}

async function deleteIscrizioneRow(anno, idPersona) {
    if (!anno || !idPersona) return;
    if (!confirm(`Eliminare definitivamente l'iscrizione ${anno} / ${idPersona}?`)) return;

    try {
        const result = await apiRequest('DELETE', API_ISCRIZIONE, { anno_associativo: anno, id_persona: idPersona });
        showResponse(result);
        fetchIscrizioni();
    } catch (error) {
        handleFetchError(error);
    }
}

async function fetchIscrizioni() {
    try {
        const data = await apiRequest('GET', API_ISCRIZIONE);
        renderIscrizioni(data);
        showResponse(data);
    } catch (error) {
        handleFetchError(error);
    }
}

async function submitIscrizioneForm(event) {
    event.preventDefault();

    const payload = {
        anno_associativo: getValue('iscrizioneAnno').trim(),
        approvazione_capo: getChecked('iscrizioneApprovazioneCapo'),
        id_persona: getValue('iscrizioneIdPersona').trim(),
        id_pagamento: getValue('iscrizioneIdPagamento').trim(),
        id_unita: getValue('iscrizioneIdUnita').trim(),
        id_iter: getValue('iscrizioneIdIter').trim(),
    };

    try {
        const method = iscrizioneFormMode === 'edit' ? 'PUT' : 'POST';
        const result = await apiRequest(method, API_ISCRIZIONE, payload);
        showResponse(result);
        resetForm('iscrizioneForm');
        setIscrizioneFormMode('create');
        fetchIscrizioni();
    } catch (error) {
        handleFetchError(error);
    }
}

function initIscrizionePage() {
    const refreshButton = getById('refreshButton');
    const iscrizioneForm = getById('iscrizioneForm');
    const resetButton = getById('iscrizioneResetButton');

    if (!refreshButton || !iscrizioneForm || !resetButton) return;

    refreshButton.addEventListener('click', fetchIscrizioni);
    iscrizioneForm.addEventListener('submit', submitIscrizioneForm);
    resetButton.addEventListener('click', () => {
        resetForm('iscrizioneForm');
        setIscrizioneFormMode('create');
    });
    setIscrizioneFormMode('create');
    fetchIscrizioni();
}

window.loadIscrizione = loadIscrizione;

window.addEventListener('DOMContentLoaded', initIscrizionePage);

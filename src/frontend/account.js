const API_ACCOUNT = '/api/account';
const API_PERSONA = '/api/persona';
let accountCache = [];
let accountPersonas = [];
let accountFormMode = 'create';

function renderAccounts(accounts) {
    const tableBody = getById('accountTableBody');
    if (!tableBody) return;

    accountCache = Array.isArray(accounts) ? accounts : [];

    if (!Array.isArray(accounts) || accounts.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="5">Nessun account trovato.</td></tr>';
        return;
    }

    tableBody.innerHTML = accounts.map(account => {
        const email = account.email || '-';
        const personaId = account.id_persona != null ? account.id_persona : '-';
        return `
            <tr data-account-username="${escapeAttr(account.username)}">
                <td>${escapeHtml(account.username)}</td>
                <td>******</td>
                <td>${escapeHtml(email)}</td>
                <td>${escapeHtml(personaId)}</td>
                <td>
                    <button class="button is-small is-info" type="button" onclick="editAccountRow('${escapeAttr(account.username)}')">Modifica</button>
                    <button class="button is-small is-danger ml-2" type="button" onclick="deleteAccountRow('${escapeAttr(account.username)}')">Elimina</button>
                </td>
            </tr>
        `;
    }).join('');
}

function setAccountFormMode(mode) {
    accountFormMode = mode === 'edit' ? 'edit' : 'create';
    const title = getById('accountFormTitle');
    const submitButton = getById('accountSubmitButton');

    if (title) {
        title.textContent = accountFormMode === 'edit' ? 'Modifica account' : 'Crea account';
    }
    if (submitButton) {
        submitButton.textContent = accountFormMode === 'edit' ? 'Modifica' : 'Crea';
        submitButton.className = accountFormMode === 'edit' ? 'button is-info' : 'button is-primary';
    }
}

function findAccountRow(username) {
    const rows = document.querySelectorAll('#accountTableBody tr');
    return Array.from(rows).find(row => row.dataset.accountUsername === username);
}

function buildAccountPersonaSelect(selectedPersonaId) {
    if (!Array.isArray(accountPersonas) || accountPersonas.length === 0) {
        return '<select class="input" disabled><option>Nessuna persona disponibile</option></select>';
    }

    return `
        <div class="select is-fullwidth">
            <select name="editAccountPersona" class="select">
                <option value="">Seleziona un ID persona</option>
                ${accountPersonas.map(persona => {
                    const label = persona.nome && persona.cognome ? `${persona.id_persona} - ${escapeHtml(persona.nome)} ${escapeHtml(persona.cognome)}` : `${persona.id_persona}`;
                    const selected = String(persona.id_persona) === String(selectedPersonaId) ? ' selected' : '';
                    return `<option value="${escapeAttr(persona.id_persona)}"${selected}>${label}</option>`;
                }).join('')}
            </select>
        </div>
    `;
}

function editAccountRow(username) {
    const account = accountCache.find(item => item.username === username);
    if (!account) return;

    const row = findAccountRow(username);
    if (!row) return;

    const usernameValue = account.username || '';
    const emailValue = account.email || '';
    const personaValue = account.id_persona != null ? account.id_persona : '';

    row.innerHTML = `
        <td><input name="editAccountUsername" class="input" type="text" value="${escapeAttr(usernameValue)}"></td>
        <td><input name="editAccountPassword" class="input" type="password" placeholder="Lascia vuoto per non cambiare"></td>
        <td><input name="editAccountEmail" class="input" type="email" value="${escapeAttr(emailValue)}"></td>
        <td>${buildAccountPersonaSelect(personaValue)}</td>
        <td>
            <button class="button is-small is-success" type="button" onclick="saveAccountRow('${escapeAttr(account.username)}')">Salva</button>
            <button class="button is-small is-light ml-2" type="button" onclick="cancelAccountRow()">Annulla</button>
        </td>
    `;
}

function cancelAccountRow() {
    renderAccounts(accountCache);
}

async function saveAccountRow(username) {
    const row = findAccountRow(username);
    if (!row) return;

    const usernameInput = row.querySelector('input[name="editAccountUsername"]');
    const passwordInput = row.querySelector('input[name="editAccountPassword"]');
    const emailInput = row.querySelector('input[name="editAccountEmail"]');
    const personaInput = row.querySelector('select[name="editAccountPersona"]');
    if (!usernameInput || !emailInput || !personaInput) return;

    const payload = {
        original_username: username,
        username: usernameInput.value.trim(),
        password: passwordInput ? passwordInput.value : '',
        email: emailInput.value.trim(),
        id_persona: personaInput.value ? Number(personaInput.value) : null,
    };

    try {
        const result = await apiRequest('PUT', API_ACCOUNT, payload);
        showResponse(result);
        fetchAccounts();
    } catch (error) {
        handleFetchError(error);
    }
}

async function deleteAccountRow(username) {
    if (!username) return;
    if (!confirm(`Eliminare definitivamente l'account '${username}'?`)) return;

    try {
        const result = await apiRequest('DELETE', API_ACCOUNT, { username });
        showResponse(result);
        fetchAccounts();
    } catch (error) {
        handleFetchError(error);
    }
}

async function fetchAccounts() {
    try {
        const data = await apiRequest('GET', API_ACCOUNT);
        renderAccounts(data);
        showResponse(data);
    } catch (error) {
        handleFetchError(error);
    }
}

function renderPersonaOptions(personas) {
    const select = getById('accountPersonaId');
    if (!select) return;

    accountPersonas = Array.isArray(personas) ? personas : [];

    if (!Array.isArray(personas) || personas.length === 0) {
        select.innerHTML = '<option value="">Nessuna persona disponibile</option>';
        select.disabled = true;
        return;
    }

    select.disabled = false;
    select.innerHTML = '<option value="">Seleziona un ID persona</option>' + personas.map(persona => {
        const label = persona.nome && persona.cognome ? `${persona.id_persona} - ${escapeHtml(persona.nome)} ${escapeHtml(persona.cognome)}` : `${persona.id_persona}`;
        return `<option value="${escapeAttr(persona.id_persona)}">${label}</option>`;
    }).join('');
}

async function fetchPersonas() {
    const select = getById('accountPersonaId');
    if (select) {
        select.disabled = true;
        select.innerHTML = '<option value="">Caricamento persone...</option>';
    }

    try {
        const data = await apiRequest('GET', API_PERSONA);
        renderPersonaOptions(data);
    } catch (error) {
        if (select) {
            select.innerHTML = '<option value="">Errore caricamento persone</option>';
            select.disabled = true;
        }
        handleFetchError(error);
    }
}

async function submitAccountForm(event) {
    event.preventDefault();

    const personaIdValue = getValue('accountPersonaId').trim();
    const payload = {
        username: getValue('accountUsername').trim(),
        password: getValue('accountPassword'),
        email: getValue('accountEmail').trim(),
        id_persona: personaIdValue ? Number(personaIdValue) : null,
    };

    try {
        const method = accountFormMode === 'edit' ? 'PUT' : 'POST';
        const result = await apiRequest(method, API_ACCOUNT, payload);
        showResponse(result);
        resetForm('accountForm');
        setAccountFormMode('create');
        fetchAccounts();
    } catch (error) {
        handleFetchError(error);
    }
}

function initAccountPage() {
    const refreshButton = getById('refreshButton');
    const accountForm = getById('accountForm');
    const resetButton = getById('accountResetButton');

    if (!refreshButton || !accountForm || !resetButton) return;

    refreshButton.addEventListener('click', fetchAccounts);
    accountForm.addEventListener('submit', submitAccountForm);
    resetButton.addEventListener('click', () => {
        resetForm('accountForm');
        setAccountFormMode('create');
    });
    setAccountFormMode('create');
    fetchPersonas();
    fetchAccounts();
}

window.addEventListener('DOMContentLoaded', initAccountPage);

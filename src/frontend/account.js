const API_ACCOUNT = '/api/account';

function renderAccounts(accounts) {
    const tableBody = getById('accountTableBody');
    if (!tableBody) return;

    if (!Array.isArray(accounts) || accounts.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="3">Nessun account trovato.</td></tr>';
        return;
    }

    tableBody.innerHTML = accounts.map(account => {
        const email = account.email || '-';
        return `
            <tr>
                <td>${escapeHtml(account.username)}</td>
                <td>${escapeHtml(email)}</td>
                <td>
                    <button class="button is-small is-info" type="button" onclick="loadAccount('${escapeAttr(account.username)}', '${escapeAttr(email)}')">Modifica</button>
                    <button class="button is-small is-danger ml-2" type="button" onclick="deleteAccountRow('${escapeAttr(account.username)}')">Elimina</button>
                </td>
            </tr>
        `;
    }).join('');
}

let accountFormMode = 'create';

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

function loadAccount(username, email) {
    setValue('accountUsername', username);
    setValue('deleteUsername', username);
    setValue('accountEmail', email);
    setAccountFormMode('edit');
    showResponse({ info: `Account caricato: ${username}` });
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

async function submitAccountForm(event) {
    event.preventDefault();

    const payload = {
        username: getValue('accountUsername').trim(),
        password: getValue('accountPassword'),
        email: getValue('accountEmail').trim(),
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
    fetchAccounts();
}

window.loadAccount = loadAccount;

window.addEventListener('DOMContentLoaded', initAccountPage);

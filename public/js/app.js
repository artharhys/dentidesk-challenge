document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#transaction-form');
    const tbody = document.querySelector('#transactions-body');
    const balanceText = document.querySelector('#balance');

    async function loadTransactions() {
        const res = await fetch('/api/transactions');
        const data = await res.json();
        renderTransactions(data.transactions, data.balance);
    }

    function renderTransactions(transactions, balance) {
        tbody.innerHTML = '';
        balanceText.textContent = `Balance actual: $${balance.toFixed(2)}`;

        if (transactions.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Sin transacciones</td></tr>';
            return;
        }

        transactions.forEach(t => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${t.description}</td>
                <td>${t.type === 'income' ? 'Ingreso' : 'Egreso'}</td>
                <td class="${t.type === 'expense' ? 'text-danger' : 'text-success'}">
                    ${t.type === 'expense' ? '-' : ''}$${t.amount}
                </td>
                <td>${t.date}</td>
                <td><button class="btn btn-sm btn-outline-danger" data-id="${t.id}">Eliminar</button></td>
            `;
            tbody.appendChild(row);
        });
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const transaction = {
            description: form.querySelector('#description').value,
            type: form.querySelector('#type').value,
            amount: parseFloat(form.querySelector('#amount').value),
            date: form.querySelector('#date').value,
        };

        await fetch('/api/transactions', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(transaction),
        });

        form.reset();
        loadTransactions();
    });

    tbody.addEventListener('click', async (e) => {
        if (e.target.matches('button[data-id]')) {
            const id = e.target.getAttribute('data-id');
            await fetch(`/api/transactions/${id}`, { method: 'DELETE' });
            loadTransactions();
        }
    });

    loadTransactions();
});

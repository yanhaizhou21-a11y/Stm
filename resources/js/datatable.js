// DataTable initialization and CRUD utilities
export class DataTableManager {
    constructor(tableId, config = {}) {
        this.tableId = tableId;
        this.table = null;
        this.config = {
            processing: true,
            serverSide: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries available",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                },
                emptyTable: "No data available"
            },
            ...config
        };
    }

    init() {
        this.table = $(`#${this.tableId}`).DataTable(this.config);
        return this;
    }

    reload() {
        if (this.table) {
            this.table.ajax.reload();
        }
        return this;
    }

    destroy() {
        if (this.table) {
            this.table.destroy();
        }
        return this;
    }
}

// CRUD Operations
export class CRUDManager {
    constructor(baseUrl, tableName) {
        this.baseUrl = baseUrl;
        this.tableName = tableName;
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    }

    async get(id) {
        try {
            const response = await fetch(`${this.baseUrl}/${id}`);
            return await response.json();
        } catch (error) {
            console.error('Error fetching data:', error);
            throw error;
        }
    }

    async create(data) {
        try {
            const response = await fetch(this.baseUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });
            return await response.json();
        } catch (error) {
            console.error('Error creating data:', error);
            throw error;
        }
    }

    async update(id, data) {
        try {
            const response = await fetch(`${this.baseUrl}/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });
            return await response.json();
        } catch (error) {
            console.error('Error updating data:', error);
            throw error;
        }
    }

    async delete(id) {
        try {
            const response = await fetch(`${this.baseUrl}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            return await response.json();
        } catch (error) {
            console.error('Error deleting data:', error);
            throw error;
        }
    }
}

// Helper function to initialize DataTable with CRUD
export function initDataTableCRUD(tableId, dataUrl, columns, baseUrl) {
    const dtManager = new DataTableManager(tableId, {
        ajax: dataUrl,
        columns: columns
    }).init();

    const crudManager = new CRUDManager(baseUrl);

    return {
        table: dtManager,
        crud: crudManager
    };
}

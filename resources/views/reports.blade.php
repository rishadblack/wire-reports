<div>
    @includeIf($view)
    {{ $datas->links() }}
    <button type="button" class="btn btn-success" wire:click="exportPdf">PDF</button>
    <button type="button" class="btn btn-success" wire:click="exportExcel">Excel</button>
</div>

@if ($i->hasPages())
<div class="pagination-container">
    @if($i->onFirstPage())
    <span class="pagination-action disabled">Назад</span>
    @else
    <a href="{{ $i->previousPageUrl() }}" class="pagination-action pagination-prev">Назад</a>
    @endif
    {{ $i->currentPage() }}
    @if($i->hasMorePages())
    <a href="{{ $i->nextPageUrl() }}" class="pagination-action pagination-next">Вперед</a>
    @else
    <span class="pagination-action disabled">Вперед</span>
    @endif
</div>
@endif

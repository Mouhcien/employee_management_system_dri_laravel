
<div class="card">
    <div class="card-header">
        <h1> Merci de confirmer votre liste </h1>
    </div>
    <div class="card-body">
        <form>

            @foreach($list_employees as $list_employee)
                <div class="input-group">
                    <label> PPR </label>
                    <input type="text" name="ppr[]" value="{{ $list_employee['ppr'] }}">
                </div>
                <div class="input-group">
                    <label> CIN </label>
                    <input type="text" name="ppr[]" value="{{ $list_employee['cin'] }}">
                </div>
                <div class="input-group">
                    <label> CIN </label>
                    <input type="text" name="ppr[]" value="{{ $list_employee['cin'] }}">
                </div>
                @break
            @endforeach
        </form>
    </div>
</div>



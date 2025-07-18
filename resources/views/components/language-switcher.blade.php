<div class="flex items-center">
    <form method="POST" action="{{ route('language.switch') }}">
        @csrf
        <select name="locale" onchange="this.form.submit()" 
                class="border rounded p-1 text-sm focus:outline-none">
            <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>
                English
            </option>
            <option value="hi" {{ app()->getLocale() === 'hi' ? 'selected' : '' }}>
                हिंदी
            </option>
        </select>
    </form>
</div>
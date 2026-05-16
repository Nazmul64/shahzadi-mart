const fs = require('fs');
const content = fs.readFileSync('e:\\shahzadi-mart\\resources\\views\\admin\\pages\\sidebar.blade.php', 'utf8');

const tags = content.match(/@if|@endif|@foreach|@endforeach|@forelse|@endforelse|@isset|@endisset|@auth|@endauth|@section|@endsection/g);
let stack = [];
let errors = [];

tags.forEach((tag, index) => {
    if (tag.startsWith('@end')) {
        let expected = tag.replace('@end', '@');
        if (stack.length === 0 || stack[stack.length - 1] !== expected) {
            errors.push(`Unexpected ${tag} at match index ${index}. Stack: ${stack.join(', ')}`);
        } else {
            stack.pop();
        }
    } else if (tag === '@section') {
        stack.push('@section');
    } else if (tag === '@if' || tag === '@foreach' || tag === '@forelse' || tag === '@isset' || tag === '@auth') {
        stack.push(tag);
    }
});

if (stack.length > 0) {
    errors.push(`Unclosed tags: ${stack.join(', ')}`);
}

if (errors.length > 0) {
    console.log("ERRORS FOUND:");
    errors.forEach(e => console.log(e));
} else {
    console.log("All Blade tags seem balanced.");
}

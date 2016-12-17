<form action="/storecourse" method="POST">
	{{csrf_field()}}
	<input type="text" name="name" placeholder="name">
	<input type="text" name="desc" placeholder="desc">
	<input type="text" name="ref" placeholder="ref">
	<input type="text" name="pRef" placeholder="pRef">
	<input type="text" name="ext" placeholder="ext">
	<button type="submit">Submit</button>
</form>
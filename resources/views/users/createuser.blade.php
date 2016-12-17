<form action="/user" method="POST">
	{{ csrf_field() }}
	<input type="text" placeholder="Nome" name="name">
	<input type="text" placeholder="Email" name="email">
	<input type="text" placeholder="Password" name="password">
	<button type="submit">Mahunna</button>
</form>
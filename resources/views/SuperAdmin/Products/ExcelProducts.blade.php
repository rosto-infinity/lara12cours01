<table>
  <thead>
  <tr>
    <th width='20' align='center'>#ID</th>
    <th width='20' align='center'>name</th>
    <th width='20' align='center'>Price</th>
    <th width='20' align='center'>description</th>

    <th>Date de création</th>
  </tr>
  </thead>
  <tbody>

       @foreach ($products as $product)
    <tr> 
        <td width='40'>{{ $product->id}}</td>
        <td width='20' align='center'>{{ $product->name}} CFA</td>
        <td width='20' align='center'>{{ $product->price}} CFA</td>
        <td width='20' align='center'>{{ $product->description }}</td>
        <td width='20' align='center'>{{ $product->created_at}}</td>
    </tr>
    @endforeach

  </tbody>
</table>
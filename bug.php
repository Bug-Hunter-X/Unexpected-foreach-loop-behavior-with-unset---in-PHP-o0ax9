function foo(array $arr) {
  foreach ($arr as $key => $value) {
    if ($value === 'bar') {
      unset($arr[$key]);
    }
  }
  return $arr;
}

$arr = ['foo', 'bar', 'baz'];
$result = foo($arr);
print_r($result); // Output: Array ( [0] => foo [2] => baz )

// Unexpected behavior:
$arr = ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'];
$result = foo($arr);
print_r($result); // Output: Array ( [foo] => foo [baz] => baz )

// The issue is that unset() modifies the array in place.
// When using unset() within a foreach loop over an array with numeric keys, the key reindexing will lead to unexpected skipping of elements.
// In the second example, after removing 'bar', the 'baz' element gets shifted to index 1, and the loop skips it.
// If the array is associative, the behavior is as expected.
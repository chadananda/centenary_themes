<?php 

// Theme view items so that if they are published, they are linked.

if ($row->node_status) {
  print l($output, "node/$row->nid");
}
else {
  print $output;
}
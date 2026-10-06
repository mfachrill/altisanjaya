@props(['value'])
<span @class(['status','status-positive'=>in_array($value,['available','confirmed']),'status-negative'=>in_array($value,['unavailable','rejected']),'status-pending'=>$value==='requested'])>{{ ucfirst($value) }}</span>

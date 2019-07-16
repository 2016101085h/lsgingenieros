@extends('principal')
@section('contenido')
<template v-if="menu==0">
    <h1>Vista de Menu 0</h1>
</template>
<template v-if="menu==1">
    <estudiante></estudiante>
</template>
<template v-if="menu==2">
        <curso></curso>
</template>
<template v-if="menu==3">
    <h1>Vista de Menu 2</h1>
</template>
<template v-if="menu==4">
    <h1>Vista de Menu 3</h1>
</template>
<template v-if="menu==5">
        <profesor></profesor>
</template>
<template v-if="menu==6">
    <h1>Vista de Menu 5</h1>
</template>
<template v-if="menu==7">
    <h1>Vista de Menu 6</h1>
</template>
<template v-if="menu==8">
    <h1>Vista de Menu 7</h1>
</template>
<template v-if="menu==9">
    <h1>Vista de Menu 8</h1>
</template>
<template v-if="menu==10">
    <h1>Vista de Menu </h1>
</template>
<template v-if="menu==11">
    <h1>Vista de Menu 10</h1>
</template>
<template v-if="menu==12">
    <h1>Vista de Menu 11</h1>
</template>
            
@endsection    
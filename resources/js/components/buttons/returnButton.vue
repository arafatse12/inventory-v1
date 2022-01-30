<template>
    <button class="btn return__button p-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
    </button>
</template>

<script>
export default {
    name: "editButton"
}
</script>

<style lang="scss" scoped>
.return__button {
    width: 35px;
    height: 35px;
    border-radius: 50rem;
    background-color: #80808047;
    opacity: 0.6;
    display: flex;
    align-items: center;
    justify-content: center;
}
.return__button:hover {
    opacity: 1;
    background-color: rgba(128, 128, 128, 0.29);
}
.icon {
    width: 20px;
    height: 20px;
    color: #2196f3;
}

</style>

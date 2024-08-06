<template>
    <span>
        <span v-if="data.created_by_user">
            <span class="badge badge-primary">C</span>
            {{ data.created_by_user ? `${data.created_by_user.name} -` : "" }}
            {{ $Helpers.logInfo(data.created_at) }}
        </span>
        <br />

        <span v-if="data.updated_by_user">
            <span class="badge badge-success">U</span>
            {{ data.updated_by_user ? `${data.updated_by_user.name} -` : "" }}
            {{ $Helpers.logInfo(data.updated_at) }}
        </span>
    </span>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
    name: "LogInfo",
    props: ["data"],
});
</script>

<!--
  -  This file is part of the lynx-media-entrance-test package.
  -
  -  (c) Artem Prosvetov <dragomeat@dragomeat.com>
  -
  -  For the full copyright and license information, please view the LICENSE
  -  file that was distributed with this source code.
  -->

<template>
    <el-container>
        <el-main>
            <div style="margin-bottom: 10px;">
                <el-row>
                    <el-col :span="12">
                        <el-select value="filters[0].value" v-model="filters[0].value" placeholder="Select anonymity type">
                            <el-option label="Not protected" value="not_protected"></el-option>
                            <el-option label="Low" value="low"></el-option>
                            <el-option label="Medium" value="medium"></el-option>
                            <el-option label="High" value="high"></el-option>
                        </el-select>
                    </el-col>
                </el-row>
            </div>
            <data-tables-server :data="data" :total="total" @query-change="getProxies" :load-data="getProxies" :filters="filters">
                <el-table-column label="Host" prop="host" key="host"></el-table-column>
                <el-table-column label="Country" prop="country" key="country" sortable="custom"></el-table-column>
                <el-table-column label="Anonymity" prop="anonymityType" key="anonymityType" sortable="custom"></el-table-column>
                <el-table-column label="Last check" prop="lastUpdatedAt" key="lastUpdatedAt" sortable="custom">
                    <template slot-scope="scope">
                        {{ scope.row.lastUpdatedAt | moment}}
                    </template>
                </el-table-column>
            </data-tables-server>
        </el-main>
    </el-container>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment';

    export default {
        name: "App",
        data() {
            return {
                data: [],
                total: 0,
                filters: [
                    {
                        prop: 'anonymityType',
                        value: [],
                    }
                ],
            };
        },
        filters: {
            moment: (date) => {
                return moment(date).fromNow();
            }
        },
        methods: {
            async getProxies(queryInfo) {
                try {
                    let params = {
                        page: queryInfo.page || 1,
                        perPage: queryInfo.pageSize || 15,
                    };

                    queryInfo.filters.forEach((filter) => {
                        params[filter.prop] = filter.value;
                    });

                    if (queryInfo.sort.prop) {
                        params['order'] = `${queryInfo.sort.prop}|${queryInfo.sort.order === 'ascending' ? 'asc' : 'desc'}`;
                    }

                    let {data} = await axios.get('/api/proxies', {
                        params
                    });

                    this.data = data.data;
                    this.total = data.meta.pagination.total;
                } catch (error) {
                    this.$message(error)
                }
            }
        }
    }
</script>

<style scoped>

</style>

import com.google.gson.annotations.SerializedName
import org.jetbrains.exposed.sql.Database
import org.jetbrains.exposed.sql.SchemaUtils
import org.jetbrains.exposed.sql.Table
import org.jetbrains.exposed.sql.insert
import org.jetbrains.exposed.sql.transactions.transaction

class DbHelper(creds: DbCreds) {

    init {
        connect(creds)
        transaction {
            SchemaUtils.create(
                    UserTb,
                    WorkerTb,
                    ClientTb,
                    ServiceTb,
                    PositionTb,
                    DepartmentTb,
                    WorkerPositionTb,
                    ServiceWorkingHoursTb)
        }
    }

    fun connect(creds: DbCreds) {
        val url = "jdbc:mysql://${creds.host}:${creds.port}/${creds.name}?useUnicode=true&characterEncoding=utf8"
        val driver = "com.mysql.cj.jdbc.Driver"
        Database.connect(url, driver, creds.user, creds.pass)
    }

    fun fillData(workersRawData: List<ParsedWorker>, mockRawData: List<MockData>) {
        transaction {
            fillClientDb(mockRawData.subList(0, 200))

            val positionList = ArrayList<String>()
            val departmentList = ArrayList<String>()
            workersRawData.forEach {
                positionList.add(it.position)
                departmentList.add(it.department)
            }
            val positionMap = fillPositionDb(positionList)
            val departmentMap = fillDepartmentDb(departmentList)

            fillWorkers(workersRawData, mockRawData.subList(200, mockRawData.size), positionMap, departmentMap)
        }
    }

    private fun fillPositionDb(positions: List<String>): Map<String, Int> {
        val resultMap = HashMap<String, Int>()
        positions.forEach { rawPosition ->
            if (!resultMap.containsKey(rawPosition)) {
                val id = PositionTb.insert {
                    it[title] = rawPosition
                } get PositionTb.id
                resultMap[rawPosition] = id!!
            }
        }
        return resultMap
    }

    private fun fillDepartmentDb(departments: List<String>): Map<String, Int> {
        val resultMap = HashMap<String, Int>()
        transaction {
            departments.forEach { rawDepartment ->
                if (!resultMap.containsKey(rawDepartment)) {
                    val id = DepartmentTb.insert {
                        it[name] = rawDepartment
                    } get DepartmentTb.id
                    resultMap[rawDepartment] = id!!
                }
            }
        }
        return resultMap
    }

    private fun fillClientDb(data: List<MockData>) {
        data.forEach { item ->
            val id = UserTb.insert {
                it[name] = item.name
                it[surname] = item.surname
                it[email] = item.email
                it[phone] = item.phone
                it[pass] = item.password
            } get UserTb.id
            ClientTb.insert {
                it[userId] = id!!
            }
        }
    }

    private fun fillWorkers(
            workerRawList: List<ParsedWorker>,
            mockList: List<MockData>,
            positionMap: Map<String, Int>,
            departmentMap: Map<String, Int>
    ) {
        var serviceInfoIndex = 0
        workerRawList.forEachIndexed { index, workerRawData ->
            val userTbId = UserTb.insert {
                it[name] = workerRawData.name
                it[surname] = workerRawData.surname
                it[email] = mockList[index].email
                it[phone] = mockList[index].phone
                it[pass] = mockList[index].password
            } get UserTb.id

            val workerTbId = WorkerTb.insert {
                it[userId] = userTbId!!
                it[departmentId] = departmentMap[workerRawData.department]!!
                it[desc] = workerRawData.description
            } get WorkerTb.id

            WorkerPositionTb.insert {
                it[workerId] = workerTbId!!
                it[positionId] = positionMap[workerRawData.position]!!
            }

            workerRawData.services.forEach { rawService ->
                val mock = mockList[serviceInfoIndex]

                val serviceTbId = ServiceTb.insert {
                    it[workerId] = workerTbId!!
                    it[name] = rawService
                    it[price] = mock.price
                    it[duration] = mock.working_hour_duration
                } get ServiceTb.id

                val fromMock = "${String.format("%02d", mock.working_hour_start)}:00:00"
                val toMock = "${String.format("%02d", mock.working_hour_start + mock.working_hour_duration)}:00:00"
                for (i in 1..5) {
                    ServiceWorkingHoursTb.insert {
                        it[serviceId] = serviceTbId!!
                        it[day] = i
                        it[from] = fromMock
                        it[to] = toMock
                    }
                }
                serviceInfoIndex++
            }
        }
    }

    data class DbCreds(
            @SerializedName("host") val host: String,
            @SerializedName("port") val port: String,
            @SerializedName("name") val name: String,
            @SerializedName("user") val user: String,
            @SerializedName("pass") val pass: String
    )
}

object UserTb : Table("User") {
    val id = integer("id").autoIncrement().primaryKey()
    val email = text("email", collate = "utf8_general_ci")
    val name = text("name", collate = "utf8_general_ci")
    val surname = text("surname", collate = "utf8_general_ci")
    val phone = varchar("phone", 20, collate = "utf8_general_ci").nullable()
    val pass = text("password", collate = "utf8_general_ci")
}

object ClientTb : Table("Client") {
    val id = integer("id").autoIncrement().primaryKey()
    val userId = (integer("user_id") references UserTb.id)
}

object WorkerTb : Table("Worker") {
    val id = integer("id").autoIncrement().primaryKey()
    val userId = (integer("user_id") references UserTb.id)
    val departmentId = (integer("department_id") references DepartmentTb.id)
    val desc = text("description", collate = "utf8_general_ci")
}

object DepartmentTb : Table("Department") {
    val id = integer("id").autoIncrement().primaryKey()
    val name = varchar("name", 250, collate = "utf8_general_ci")
}

object WorkerPositionTb : Table("Worker_position") {
    val id = integer("id").autoIncrement().primaryKey()
    val workerId = (integer("worker_id") references WorkerTb.id)
    val positionId = (integer("position_id") references PositionTb.id)
}

object PositionTb : Table("Position") {
    val id = integer("id").autoIncrement().primaryKey()
    val title = varchar("title", 250, collate = "utf8_general_ci")
}

object ServiceTb : Table("Service") {
    val id = integer("id").autoIncrement().primaryKey()
    val name = varchar("name", 250, collate = "utf8_general_ci")
    val workerId = (integer("worker_id") references WorkerTb.id)
    val price = integer("price")
    val duration = integer("duration")
}

object ServiceWorkingHoursTb : Table("Service_working_hours") {
    val id = integer("id").autoIncrement().primaryKey()
    val serviceId = (integer("service_id") references ServiceTb.id)
    val day = integer("day")
    val from = text("from", collate = "utf8_general_ci")
    val to = text("to", collate = "utf8_general_ci")
}
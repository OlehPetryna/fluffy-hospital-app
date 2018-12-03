import com.google.gson.Gson
import com.google.gson.annotations.SerializedName
import com.google.gson.reflect.TypeToken
import java.io.File
import java.util.ArrayList


class Main {
    companion object {

        @JvmStatic
        fun main(args: Array<String>) {
            fillDb()
        }

        fun fillDb() {
            val links = File(Main::class.java.getResource("links.txt").file).readLines()
            val parsedWorkers = parseLinks(links)

            val jsonMock = File(Main::class.java.getResource("mock_data.json").file).readText()
            val mockData = Gson().fromJson<ArrayList<MockData>>(jsonMock, object : TypeToken<ArrayList<MockData>>() {}.type)

            val jsonCreds = File(Main::class.java.getResource("creds.json").file).readText()
            val creds = Gson().fromJson<DbHelper.DbCreds>(jsonCreds, DbHelper.DbCreds::class.java)

            DbHelper(creds).fillData(parsedWorkers, mockData)
        }
    }
}

data class MockData(
        @SerializedName("email") val email: String,
        @SerializedName("phone") val phone: String,
        @SerializedName("password") val password: String,
        @SerializedName("working_hour_start") val working_hour_start: Int,
        @SerializedName("working_hour_duration") val working_hour_duration: Int,
        @SerializedName("name") val name: String,
        @SerializedName("surname") val surname: String,
        @SerializedName("price") val price: Int
)
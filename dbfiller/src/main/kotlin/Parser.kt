import org.jsoup.Jsoup

fun parseLinks(links: List<String>): List<ParsedWorker> {
    val workers = arrayListOf<ParsedWorker>()
    links.forEach { link ->
        val doc = Jsoup.connect(link).get()
        val lists = doc.getElementsByClass("rich-content").select("ul")

        val fullName = doc
                .getElementsByClass("fn hidden")
                .text()
                .split(' ')
        val position = doc
                .getElementsByClass("card__label__text")
                .text()
                .split(", ")
                .first()
        val desc = doc
                .getElementsByClass("card__description__text")
                .text()
        val services = lists[lists.size - 2]
                .children()
                .eachText()
                .map { str ->
                    str.filterNot { char -> char in listOf(',', ';', '.') }
                    str.capitalize()
                }
        val department = position.split('-', ' ').last().capitalize() + "ия"

        workers.add(
                ParsedWorker(
                        name = fullName[1],
                        surname = fullName[0],
                        position = position,
                        description = desc,
                        services = services,
                        department = department
                ).also { println(it) }
        )
    }
    return workers
}

data class ParsedWorker(
        val name: String,
        val surname: String,
        val position: String,
        val department: String,
        val description: String,
        val services: List<String>
)
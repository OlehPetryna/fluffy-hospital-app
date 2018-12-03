import org.jetbrains.kotlin.gradle.tasks.KotlinCompile

plugins {
    kotlin("jvm") version "1.3.10"
}

group = "fluffyrice"
version = "1.0-SNAPSHOT"

repositories {
    mavenCentral()
    jcenter()
}

dependencies {
    compile(kotlin("stdlib-jdk8"))
    compile("mysql", "mysql-connector-java", "8.0.13")
    compile("org.jetbrains.exposed", "exposed", "0.11.2")
    compile("org.jsoup", "jsoup", "1.11.3")
    compile("com.google.code.gson", "gson", "2.8.5")

    compile("org.slf4j", "slf4j-api", "1.7.5")
    compile("org.slf4j", "slf4j-log4j12", "1.7.5")
}

tasks.withType<KotlinCompile> {
    kotlinOptions.jvmTarget = "1.8"
}
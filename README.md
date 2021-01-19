# Covid19ReportSystem


# Brief Summary about the Project
- This project is a World Wide - Covid 19 Report System, based on Java,MySQL and Php languages.
- Data are gathering from the API by using Java. Then transferred to mySQL on every 1 hour.(This provides a real time data gathering, fresh data. 
- By using Php the Data and wanted tables refreshing in every 1 seconds to showing the up to date site.

# Setting up the site on local hosts.
## Step 1.

- Launch XAMMP.
- Start the apache and mySQL.
- Press the admin button from the mySQL.
- Phpmyadmin page will be gonna appear on the screen. On the top-left of the page there should be a new button. Click the new button then, write your database name. In our project we named it 'covidservice'. You can call it what ever you want BUT YOU HAVE TO CHANGE THE NAME $database = "covidservice"; TO $database = "yourwantedname"; in every .php file.
- Select the Database that we created.
- Insered the codes that below.

WARNING !!!
AFTER EACH OPERATION. YOU SHOULD CLICK GO ON MYPHP PAGE AND FROM YOU JAVA IDE RUN THE CODE. 
YOU MUST DO THIS FOR EVERY PHPMYADMIN OPERATION.
IF YOU WON'T DO THIS YOUR DATA WILL NOT WORK CORRECTLY.
### 1. TABLE
```
create table generaltable (
    updated bigint(14) NOT NULL,
    country varchar(40) PRIMARY KEY NOT NULL,
    flag varchar(50),
    cases int(11),
    todayCases int(11),
    deaths int(11),
    todayDeaths int(11),
    recovered int(11),
    todayRecovered int(11),
    active int(11),
    critical int(11),
    casesPerOneMillion int(11),
    deathsPerOneMillion int(11),
    tests int(11),
    testsPerOneMillion int(11),
    population int(11),
    continent char(25),
    oneCasePerPeople int(11),
    oneDeathPerPeople int(11),
    oneTestPerPeople int(11),
    activePerOneMillion double,
    recoveredPerOneMillion double,
    criticalPerOneMillion double);
```
### 2. TABLE
```
CREATE TABLE casesPercentage
SELECT country,cases,todayCases, (100*cases)/population AS caseByPop
FROM generaltable;
```

### 3. TABLE
```
CREATE TABLE testsPercentage
SELECT country,tests, (100*tests)/population AS testByPop, (100*cases)/tests AS caseByTest
FROM generaltable;
```

### 4. TABLE
```
CREATE TABLE deathsPercentage
SELECT country, deaths, (100*deaths)/population AS deadByPop, (100*deaths)/cases AS deadByCase
FROM generaltable;
```

### 5. TABLE
```
CREATE TABLE recoveredPercentage
SELECT country, recovered, (100*recovered)/population AS recoverByPop, (100*recovered)/cases AS recoverByCase
FROM generaltable;
```
### 6. TABLE
```
SELECT cp.country, caseByPop, testByPop, caseByTest, deadByPop, deadByCase, recoverByPop, recoverbyCase,  flag 
FROM casesPercentage AS cp 
JOIN testsPercentage AS tp ON cp.country = tp.country 
JOIN deathsPercentage AS dp ON tp.country = dp.country 
JOIN recoveredPercentage AS rp ON dp.country = rp.country 
JOIN generaltable AS gt ON rp.country = gt.country ORDER BY `cp`.`country` ASC;
```
### 7. TABLE
```
CREATE TABLE continents(
    continent CHAR(25) PRIMARY KEY NOT NULL,
        cases INT,
        deaths INT,
        recovered INT,
        active INT,
        critical INT,
        tests INT,
        population INT);
```
### 8. INSERT the contınents TABLE
```
INSERT INTO continents (continent,cases,deaths,recovered,active,critical,tests,population)
SELECT 
    'Asia',sum(cases),sum(deaths),sum(recovered),sum(active),sum(critical),sum(tests),sum(population)
FROM
    generaltable
WHERE
    generaltable.continent = 'Asia';
```
### 9. INSERT the contınents TABLE
```
INSERT INTO continents (continent,cases,deaths,recovered,active,critical,tests,population)
SELECT 
    'Europe',sum(cases),sum(deaths),sum(recovered),sum(active),sum(critical),sum(tests),sum(population)
FROM
    generaltable
WHERE
    generaltable.continent = 'Europe';
```
### 10. INSERT the contınents TABLE
```
INSERT INTO continents (continent,cases,deaths,recovered,active,critical,tests,population)
SELECT 
    'North America',sum(cases),sum(deaths),sum(recovered),sum(active),sum(critical),sum(tests),sum(population)
FROM
    generaltable
WHERE
    generaltable.continent = 'North America';
```
### 11. INSERT the contınents TABLE
```
INSERT INTO continents (continent,cases,deaths,recovered,active,critical,tests,population)
SELECT 
    'South America',sum(cases),sum(deaths),sum(recovered),sum(active),sum(critical),sum(tests),sum(population)
FROM
    generaltable
WHERE
    generaltable.continent = 'South America';
```
### 12. INSERT the contınents TABLE
```
INSERT INTO continents (continent,cases,deaths,recovered,active,critical,tests,population)
SELECT 
    'Africa',sum(cases),sum(deaths),sum(recovered),sum(active),sum(critical),sum(tests),sum(population)
FROM
    generaltable
WHERE
    generaltable.continent = 'Africa';
```
### 13. INSERT the contınents TABLE
```
INSERT INTO continents (continent,cases,deaths,recovered,active,critical,tests,population)
SELECT 
    'Australia/Oceania',sum(cases),sum(deaths),sum(recovered),sum(active),sum(critical),sum(tests),sum(population)
FROM
    generaltable
WHERE
    generaltable.continent = 'Australia/Oceania';
```

- After all the wanted code inserted one by one or as a whole. Click the go button.
- Your table has been successfully created.

## Step 2
- Open the XAMMP folder in your PC.
- Open the htdocs file inside the XAMPP folder and copy-paste all the 'PHP' documents from the github.

## Step 3
- Open your Java IDE and then copy paste the java source code from the github and run. This will update the database.
- After all operations finish test it yourself.

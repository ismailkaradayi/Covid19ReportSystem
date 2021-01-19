create database covidservice;
use covidservice;
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
    
CREATE TABLE casesPercentage
SELECT country,cases,todayCases, (100*cases)/population AS caseByPop
FROM generaltable;

CREATE TABLE testsPercentage
SELECT country,tests, (100*tests)/population AS testByPop, (100*cases)/tests AS caseByTest
FROM generaltable;

CREATE TABLE deathsPercentage
SELECT country, deaths, (100*deaths)/population AS deadByPop, (100*deaths)/cases AS deadByCase
FROM generaltable;

CREATE TABLE recoveredPercentage
SELECT country, recovered, (100*recovered)/population AS recoverByPop, (100*recovered)/cases AS recoverByCase
FROM generaltable;

SELECT cp.country, caseByPop, testByPop, caseByTest, deadByPop, deadByCase, recoverByPop, recoverbyCase,  flag 
FROM casesPercentage AS cp 
JOIN testsPercentage AS tp ON cp.country = tp.country 
JOIN deathsPercentage AS dp ON tp.country = dp.country 
JOIN recoveredPercentage AS rp ON dp.country = rp.country 
JOIN generaltable AS gt ON rp.country = gt.country ORDER BY `cp`.`country` ASC


CREATE TABLE continents(
    continent CHAR(25) PRIMARY KEY NOT NULL,
        cases INT,
        deaths INT,
        recovered INT,
        active INT,
        critical INT,
        tests INT,
        population INT);

INSERT INTO continents (continent,cases,deaths,recovered,active,critical,tests,population)
SELECT 
    'Asia',sum(cases),sum(deaths),sum(recovered),sum(active),sum(critical),sum(tests),sum(population)
FROM
    generaltable
WHERE
    generaltable.continent = 'Asia';

INSERT INTO continents (continent,cases,deaths,recovered,active,critical,tests,population)
SELECT 
    'Europe',sum(cases),sum(deaths),sum(recovered),sum(active),sum(critical),sum(tests),sum(population)
FROM
    generaltable
WHERE
    generaltable.continent = 'Europe';

INSERT INTO continents (continent,cases,deaths,recovered,active,critical,tests,population)
SELECT 
    'North America',sum(cases),sum(deaths),sum(recovered),sum(active),sum(critical),sum(tests),sum(population)
FROM
    generaltable
WHERE
    generaltable.continent = 'North America';

INSERT INTO continents (continent,cases,deaths,recovered,active,critical,tests,population)
SELECT 
    'South America',sum(cases),sum(deaths),sum(recovered),sum(active),sum(critical),sum(tests),sum(population)
FROM
    generaltable
WHERE
    generaltable.continent = 'South America';

INSERT INTO continents (continent,cases,deaths,recovered,active,critical,tests,population)
SELECT 
    'Africa',sum(cases),sum(deaths),sum(recovered),sum(active),sum(critical),sum(tests),sum(population)
FROM
    generaltable
WHERE
    generaltable.continent = 'Africa';

INSERT INTO continents (continent,cases,deaths,recovered,active,critical,tests,population)
SELECT 
    'Australia/Oceania',sum(cases),sum(deaths),sum(recovered),sum(active),sum(critical),sum(tests),sum(population)
FROM
    generaltable
WHERE
    generaltable.continent = 'Australia/Oceania';
import org.json.JSONArray;
import org.json.JSONObject;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;
import java.sql.*;
import java.util.ArrayList;
import java.util.concurrent.TimeUnit;

public class SqlService {
    // SQL Database bağlan
    private static String dbLocation = "jdbc:mysql://localhost/covidservice?useUnicode=true&useLegacyDatetimeCode=false&serverTimezone=Turkey";
    private static String name = "root";
    private static String password = null;
    private static Connection myConnection;
    private static Statement myStatement;

    // KULLANDIGIMIZ API nın Base URL
    private static String BASE_URL = "https://corona.lmao.ninja/v2/countries?yesterday&sort";
    // Çektiğimiz datayı tutuğumuz Arraylist
    private static ArrayList<CovidData> covidData = new ArrayList<>();

    public static void main(String[] args) {
        try {
            // SQL driver bağlanıyoruz dataya kullanıcı bilgileriyle
            myConnection = (Connection) DriverManager.getConnection(dbLocation,name,password);
            myStatement = myConnection.createStatement();

            // While döngüsü ile TimeUnit yaparak 1 saate bir Veri güncellemesi yapıyoruz
            while (true){
                // datarefresh ediliyor
                databaseRefresh();
                // saatlik delay
                TimeUnit.HOURS.sleep(1);
            }
        }catch (Exception e){
            System.out.println(e.getMessage());
        }
    }


    private static void databaseRefresh(){
        // tekrarlı veri oldugu için arrayin ustune yazmaması için arraylisti her seferinde temziliyoruz
        covidData.clear();
        // org.json.JSONArray Kütüphanesi kullanrarak bir Json Array oluşturduk getCountry() methodundan Json Array dondurduğumuz veriyi çekiyoruz ve JSONArraye eşitliyoruz
        JSONArray jsonArray = getCountry();
        // JSONArray in uzunlugu kadar donucek bir for döngüsü kuruyoruz
        for (int i = 0; i < jsonArray.length();i++){
            try {
                // JSONOBject ile o anki array blogunun içindeki veriyi çekiyoruz
                JSONObject jsonObject = jsonArray.getJSONObject(i);
                long updated = jsonObject.getLong("updated");
                String country = jsonObject.getString("country");
                // JSON Object içindeki başka bir Objectk içindeki dallanmadan  countryInfo
                JSONObject countryInfo = jsonObject.getJSONObject("countryInfo");
                // countryInfo objesini çekiyoruz
                String flag = countryInfo.getString("flag");
                int cases = jsonObject.getInt("cases");
                int todayCases = jsonObject.getInt("todayCases");
                int deaths = jsonObject.getInt("deaths");
                int todayDeaths = jsonObject.getInt("todayDeaths");
                int recovered = jsonObject.getInt("recovered");
                int todayRecovered = jsonObject.getInt("todayRecovered");
                int active = jsonObject.getInt("active");
                int critical = jsonObject.getInt("critical");
                int casesPerOneMillion = jsonObject.getInt("casesPerOneMillion");
                int deathsPerOneMillion = jsonObject.getInt("deathsPerOneMillion");
                int tests = jsonObject.getInt("tests");
                int testsPerOneMillion = jsonObject.getInt("testsPerOneMillion");
                int population = jsonObject.getInt("population");
                String  continent = jsonObject.getString("continent");
                int oneCasePerPeople = jsonObject.getInt("oneCasePerPeople");
                int oneDeathPerPeople = jsonObject.getInt("oneDeathPerPeople");
                int oneTestPerPeople = jsonObject.getInt("oneTestPerPeople");
                double activePerOneMillion = jsonObject.getDouble("activePerOneMillion");
                double recoveredPerOneMillion = jsonObject.getDouble("recoveredPerOneMillion");
                double criticalPerOneMillion = jsonObject.getDouble("criticalPerOneMillion");

                // HER for Dongusunde Oluşturduğumuz covidData Arraylistine ekleme yapıyoruz
                covidData.add(new CovidData(updated, country, flag, cases, todayCases, deaths, todayDeaths, recovered,
                        todayRecovered, active, critical, casesPerOneMillion, deathsPerOneMillion, tests,
                        testsPerOneMillion, population, continent, oneCasePerPeople, oneDeathPerPeople, oneTestPerPeople,
                        activePerOneMillion, recoveredPerOneMillion, criticalPerOneMillion));

            }catch (Exception e){
                System.out.println(e.getMessage());
            }
        }

        try{
            // Her seferinde veriler ust üstüne binmesin diye database i temizliyoruz
            String delete = "DELETE FROM generaltable";
            PreparedStatement deleteStatement = myConnection.prepareStatement(delete);
            deleteStatement.executeUpdate();

            // covidData Arraylistimizi for dongusu ile yazdırıyoruz ve SQL deki database e tek tek aktarıyuz
            for (CovidData in : covidData){
                String query = "INSERT INTO generaltable(updated, country, flag, cases,todayCases, deaths, " +
                        "todayDeaths, recovered, todayRecovered, active, critical, " +
                        "casesPerOneMillion, deathsPerOneMillion, tests, testsPerOneMillion, population, " +
                        "continent, oneCasePerPeople, oneDeathPerPeople, oneTestPerPeople, " +
                        "activePerOneMillion, recoveredPerOneMillion, criticalPerOneMillion)"+
                        "VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                PreparedStatement preparedStatement = myConnection.prepareStatement(query);
                preparedStatement.setLong(1, in.getUpdated());
                preparedStatement.setString(2, in.getCountry());
                preparedStatement.setString(3, in.getFlag());
                preparedStatement.setInt(4, in.getCases());
                preparedStatement.setInt(5, in.getTodayCases());
                preparedStatement.setInt(6, in.getDeaths());
                preparedStatement.setInt(7, in.getTodayDeaths());
                preparedStatement.setInt(8, in.getRecovered());
                preparedStatement.setInt(9, in.getTodayRecovered());
                preparedStatement.setInt(10, in.getActive());
                preparedStatement.setInt(11, in.getCritical());
                preparedStatement.setInt(12, in.getCasesPerOneMillion());
                preparedStatement.setInt(13, in.getDeathsPerOneMillion());
                preparedStatement.setInt(14, in.getTests());
                preparedStatement.setInt(15, in.getTestsPerOneMillion());
                preparedStatement.setInt(16, in.getPopulation());
                preparedStatement.setString(17, in.getContinent());
                preparedStatement.setInt(18, in.getOneCasePerPeople());
                preparedStatement.setInt(19, in.getOneDeathPerPeople());
                preparedStatement.setInt(20, in.getOneTestPerPeople());
                preparedStatement.setDouble(21, in.getActivePerOneMillion());
                preparedStatement.setDouble(22, in.getRecoveredPerOneMillion());
                preparedStatement.setDouble(23, in.getCriticalPerOneMillion());
                preparedStatement.executeUpdate();
            }
            System.out.println("Upload Success");
        }catch (Exception e){
            System.out.println(e.getMessage());
        }
    }

    // URL Kullanarak BASE URL aracılıgı ile api mize bağlanıyurz
    // BufferedReader kullanarak api safasını okuyurz
    // while dongusu ile sitedeki her staırı tektek bir Stringe ekliyoruz ve O stringi de JSONArraye parselliyoruz
    private static JSONArray getCountry(){
        try{
            URL url = new URL(BASE_URL);
            URLConnection uC = url.openConnection();
            BufferedReader in = new BufferedReader(new InputStreamReader(uC.getInputStream()));
            String  inputLine;
            JSONArray country = null;
            while ((inputLine = in.readLine())!= null){
                country = new JSONArray(inputLine);
            }
            return country;
        }catch (Exception e){
            System.out.println(e.getMessage());
            return null;
        }
    }
}
class CovidData{
    private long updated;
    private String country;
    private String flag;
    private int cases, todayCases, deaths, todayDeaths, recovered, todayRecovered, active, critical, casesPerOneMillion, deathsPerOneMillion,tests, testsPerOneMillion, population;
    private String  continent;
    private int oneCasePerPeople, oneDeathPerPeople, oneTestPerPeople;
    private double activePerOneMillion, recoveredPerOneMillion, criticalPerOneMillion;

    public CovidData(long updated, String country, String flag, int cases, int todayCases, int deaths, int todayDeaths, int recovered, int todayRecovered, int active, int critical, int casesPerOneMillion, int deathsPerOneMillion, int tests, int testsPerOneMillion, int population, String continent, int oneCasePerPeople, int oneDeathPerPeople, int oneTestPerPeople, double activePerOneMillion, double recoveredPerOneMillion, double criticalPerOneMillion) {
        this.updated = updated;
        this.country = country;
        this.flag = flag;
        this.cases = cases;
        this.todayCases = todayCases;
        this.deaths = deaths;
        this.todayDeaths = todayDeaths;
        this.recovered = recovered;
        this.todayRecovered = todayRecovered;
        this.active = active;
        this.critical = critical;
        this.casesPerOneMillion = casesPerOneMillion;
        this.deathsPerOneMillion = deathsPerOneMillion;
        this.tests = tests;
        this.testsPerOneMillion = testsPerOneMillion;
        this.population = population;
        this.continent = continent;
        this.oneCasePerPeople = oneCasePerPeople;
        this.oneDeathPerPeople = oneDeathPerPeople;
        this.oneTestPerPeople = oneTestPerPeople;
        this.activePerOneMillion = activePerOneMillion;
        this.recoveredPerOneMillion = recoveredPerOneMillion;
        this.criticalPerOneMillion = criticalPerOneMillion;
    }

    public long getUpdated() {
        return updated;
    }

    public String getCountry() {
        return country;
    }

    public String getFlag() {
        return flag;
    }

    public int getCases() {
        return cases;
    }

    public int getTodayCases() {
        return todayCases;
    }

    public int getDeaths() {
        return deaths;
    }

    public int getTodayDeaths() {
        return todayDeaths;
    }

    public int getRecovered() {
        return recovered;
    }

    public int getTodayRecovered() {
        return todayRecovered;
    }

    public int getActive() {
        return active;
    }

    public int getCritical() {
        return critical;
    }

    public int getCasesPerOneMillion() {
        return casesPerOneMillion;
    }

    public int getDeathsPerOneMillion() {
        return deathsPerOneMillion;
    }

    public int getTests() {
        return tests;
    }

    public int getTestsPerOneMillion() {
        return testsPerOneMillion;
    }

    public int getPopulation() {
        return population;
    }

    public String getContinent() {
        return continent;
    }

    public int getOneCasePerPeople() {
        return oneCasePerPeople;
    }

    public int getOneDeathPerPeople() {
        return oneDeathPerPeople;
    }

    public int getOneTestPerPeople() {
        return oneTestPerPeople;
    }

    public double getActivePerOneMillion() {
        return activePerOneMillion;
    }

    public double getRecoveredPerOneMillion() {
        return recoveredPerOneMillion;
    }

    public double getCriticalPerOneMillion() {
        return criticalPerOneMillion;
    }
}


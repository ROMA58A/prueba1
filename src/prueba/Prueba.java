package prueba;

import java.awt.Desktop;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.io.Writer;
import java.sql.*;
import java.util.*;
import com.google.gson.*;
import java.io.BufferedWriter;

public class Prueba {

    public static void main(String[] args) {
      // modificar en el bloque el nombre de tabla y la carpeta donde se guardara el archivo json  
        MySQLDatabaseManager dbManager = new MySQLDatabaseManager();
        String tableName = "prueba1";
       String fileName = "C:/Users/RODRIGUEZ/Desktop/datos.json";



        try {
            dbManager.connectToDatabase("jdbc:mysql://localhost:3306/conex", "root", "");
            dbManager.exportTableToJson(tableName, fileName);
            System.out.println("La tabla " + tableName + " ha sido exportada a " + fileName);

            // Abrir el archivo JSON con el programa predeterminado del sistema
            Desktop.getDesktop().open(new File(fileName));

        } catch (SQLException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

}

class MySQLDatabaseManager {
    private Connection connection;
    private Gson gson = new Gson();

    public void connectToDatabase(String url, String username, String password) throws SQLException {
        connection = DriverManager.getConnection(url, username, password);
    }
public void exportTableToJson(String tableName, String fileName) throws SQLException, IOException {
    PreparedStatement statement = connection.prepareStatement("SELECT * FROM " + tableName);
    ResultSet resultSet = statement.executeQuery();
    ResultSetMetaData metaData = resultSet.getMetaData();
    int columnCount = metaData.getColumnCount();

    // Crear una lista para almacenar los nombres de las columnas
    List<String> columnNames = new ArrayList<>();
    for (int i = 1; i <= columnCount; i++) {
        columnNames.add(metaData.getColumnLabel(i));
    }

    // Crear una lista para almacenar los datos de la tabla
    List<Map<String, Object>> tableData = new ArrayList<>();

    // Recorrer cada fila del resultSet
    while (resultSet.next()) {
        // Crear un nuevo mapa para almacenar los valores de la fila actual
        Map<String, Object> rowData = new LinkedHashMap<>();

        // Agregar cada valor de columna al mapa con su nombre correspondiente
        for (int i = 1; i <= columnCount; i++) {
            Object value = resultSet.getObject(i);
            String columnName = metaData.getColumnLabel(i);
            rowData.put(columnName, value);
        }

        // Agregamos al  mapa los  valores de la fila a la lista de datos de la tabla
        tableData.add(rowData);
    }

    // Agregamos  la lista de nombres de columnas al principio de la lista de datos de la tabla
    tableData.add(0, new LinkedHashMap<>());
    for (String columnName : columnNames) {
        tableData.get(0).put(columnName, null);
    }

    //  se convirte a  la lista de mapas a una representación JSON
    String json = gson.toJson(tableData);

    // Escribir el JSON a un archivo
    
// Escribir el JSON a un archivo con salto de línea por fila
try (BufferedWriter writer = new BufferedWriter(new FileWriter(fileName))) {
    for (Map<String, Object> rowData : tableData) {
        String rowJson = gson.toJson(rowData);
        writer.write(rowJson);
        writer.newLine();
    }
}

// Imprimir el número de filas exportadas
int rowCount = tableData.size() - 1;
System.out.println("Exportando " + rowCount + " filas a JSON con salto de línea por fila...");
}
}
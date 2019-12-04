from flask import Flask
import mysql.connector
import json
from flask import jsonify, request

app = Flask(__name__)
app.secret_key = "BEDETE"
app.config['MYSQL_HOST'] = '192.168.16.33'
app.config['MYSQL_PORT'] = 4000
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'news'

db = mysql.connector.connect(
  host="192.168.16.33",
  user="root",
  passwd="",
  database="news",
  port=4000
)

@app.route('/news/c', methods=['GET'])
def by_title():
    cur = db.cursor()
    
    cur.execute("SELECT * FROM data WHERE category=\"BEDETE\"")

    data = []
    for (category, headline, authors, link, short_description, date) in cur:
        temp = {}
        temp["category"] = category;
        temp["headline"] = headline;
        temp["authors"] = authors;
        temp["link"] = link;
        temp["short_description"] = short_description;
        temp["date"] = date;
        data.append(temp)

    db.commit()
    cur.close()
    resp = json.dumps(data)
    return resp

@app.route('/news', methods=['GET'])
def get_news():
    cur = db.cursor()
    cur.execute("SELECT * FROM data")

    data = []
    for (category, headline, authors, link, short_description, date) in cur:
        temp = {}
        temp["category"] = category;
        temp["headline"] = headline;
        temp["authors"] = authors;
        temp["link"] = link;
        temp["short_description"] = short_description;
        temp["date"] = date;
        data.append(temp)

    db.commit()
    cur.close()
    resp = json.dumps(data)
    return resp

@app.route('/news', methods=['POST'])
def add_news():
    request_json = request.json
    news_category = request_json["category"]
    news_headline = request_json["headline"]
    news_authors = request_json["authors"]
    news_link = request_json["link"]
    news_short_description = request_json["short_description"]
    news_date = request_json["date"]

    
    cur = db.cursor()
    cur.execute("INSERT INTO data VALUES (%s, %s, %s, %s, %s, %s)", (news_category, news_headline, news_authors, news_link, news_short_description, news_date));
    db.commit()
    cur.close()

    resp = jsonify('News added successfully!')
    resp.status_code = 200
    return resp

@app.route('/news/<id>',methods=['PUT'])
def update_news(id):
    request_json = request.json
    news_category = request_json["category"]
    news_headline = request_json["headline"]
    news_authors = request_json["authors"]
    news_link = request_json["link"]
    news_short_description = request_json["short_description"]
    news_date = request_json["date"]

    cur = db.cursor()
    cur.execute("UPDATE data SET date = %s WHERE category = %s AND headline = %s AND authors = %s AND link = %s AND short_description = %s", (news_date, news_category, news_headline, news_authors, news_link, news_short_description));
    db.commit()
    cur.close()

    resp = jsonify('News updated successfully!')
    resp.status_code = 200
    return resp

@app.route('/news/<id>', methods=['DELETE'])
def delete_news(id):
    request_json = request.json
    news_category = request_json["category"]
    news_headline = request_json["headline"]
    news_authors = request_json["authors"]
    news_link = request_json["link"]
    news_short_description = request_json["short_description"]
    news_date = request_json["date"]

    cur = db.cursor()
    cur.execute("DELETE FROM data WHERE category = %s AND headline = %s AND authors = %s AND link = %s AND short_description = %s AND date = %s", (news_category, news_headline, news_authors, news_link, news_short_description, news_date));
    db.commit()
    cur.close()

    resp = jsonify('News deleted successfully!')
    resp.status_code = 200
    return resp

if __name__ == "__main__":
    app.run()